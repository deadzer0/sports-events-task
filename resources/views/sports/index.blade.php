@extends('layouts.app')

@section('content')
    <h1>Sports Events</h1>
    <div id="sportsData">
        <!-- Load data dynamic -->
    </div>
    <div class="last-update" id="lastUpdate"></div>
@endsection

@push('scripts')
    <script>
        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function fetchData() {
            console.log('fetching')
            // Adding fade-out effect
            document.getElementById('sportsData').style.opacity = '0.5';
            document.getElementById('sportsData').style.transition = 'opacity 0.3s';

            fetch('/api/v1/sport-data')
                .then(response => response.json())
                .then(data => {
                    const sportsDataDiv = document.getElementById('sportsData');
                    sportsDataDiv.innerHTML = ''; // clean prev content

                    data.data.forEach(tournament => {
                        // Shuffle/randomize season matches
                        tournament.seasons.forEach(season => {
                            season.games = shuffleArray([...season.games]);
                        });

                        const tournamentSection = document.createElement('div');
                        tournamentSection.className = 'tournament-section';

                        const tournamentTitle = document.createElement('h2');
                        tournamentTitle.className = 'tournament-title';
                        tournamentTitle.textContent = `${tournament.name} - Season ${tournament.seasons[0].name}`;

                        const table = document.createElement('table');
                        table.innerHTML = `
                       <thead>
                           <tr>
                               <th>Date</th>
                               <th>Home Team</th>
                               <th>Away Team</th>
                               <th>Score</th>
                               <th>Status</th>
                               <th>Venue</th>
                           </tr>
                       </thead>
                       <tbody>
                           ${tournament.seasons.map(season =>
                            season.games.map(game => `
                                   <tr>
                                       <td>${new Date(game.start_datetime).toLocaleString()}</td>
                                       <td>${game.home_team.name}</td>
                                       <td>${game.away_team.name}</td>
                                       <td>${game.game_result ?
                                `${game.game_result.home_team_score} - ${game.game_result.away_team_score}`
                                : '-'}</td>
                                       <td><span class="status status-${game.status}">${game.status === 'in_progress' ? 'in progress' : game.status}</span></td>
                                       <td>${game.venue}</td>
                                   </tr>
                               `).join('')
                        ).join('')}
                       </tbody>
                   `;

                        tournamentSection.appendChild(tournamentTitle);
                        tournamentSection.appendChild(table);
                        sportsDataDiv.appendChild(tournamentSection);
                    });

                    setTimeout(() => {
                        sportsDataDiv.style.opacity = '1';
                    }, 300);

                    document.getElementById('lastUpdate').textContent =
                        `Last updated: ${new Date(data.timestamp).toLocaleString()}`;
                })
                .catch(error => console.error('Error:', error));
        }

        const style = document.createElement('style');
        style.textContent = `
       #sportsData {
           transition: opacity 0.3s ease-in-out;
       }
       .tournament-section {
           transition: all 0.3s ease-in-out;
       }
   `;
        document.head.appendChild(style);

        // Initial loading data
        fetchData();

        // Refresh every minute
        setInterval(fetchData, 60000);
    </script>
@endpush
