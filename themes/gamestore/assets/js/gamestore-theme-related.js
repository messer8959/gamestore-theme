// Dark mode style

let styleMode = localStorage.getItem('styleMode');
const styleToggle = document.querySelector('.header-mode-switcher');
if (styleToggle) {
    styleToggle.addEventListener('click', () => {
        styleMode = localStorage.getItem('styleMode');
        if (styleMode === 'dark') {
            disableDarkStyle();
        } else {
            enebleDarkStyle();
        }
    });
}

const enebleDarkStyle = () => {
    document.body.classList.add('dark-mode-gamestore');
    localStorage.setItem('styleMode', 'dark');
}
const disableDarkStyle = () => {
    document.body.classList.remove('dark-mode-gamestore');
    localStorage.setItem('styleMode', 'light');
}
if (styleMode === 'dark') {
    enebleDarkStyle();
}

document.querySelector('.header-search').addEventListener('click', function () {
    document.querySelector('.popup-games-search-container').style.display = 'block';
});
document.getElementById('close-search').addEventListener('click', function () {
    document.querySelector('.popup-games-search-container').style.display = 'none';
});

document.addEventListener('DOMContentLoaded', function () {
    const searchContainer = document.querySelector('.popup-games-search-container');
    const searchResults = document.querySelector('.popup-search-results');
    const searchInput = document.getElementById('popup-search-input');
    const openButton = document.querySelector('.header-search');
    const closeButton = document.getElementById('close-search');
    const titleElement = document.querySelector('.search-popup-title');

    openButton.addEventListener('click', function () {
        searchContainer.style.display = 'block';
        titleElement.textContent = 'You might be interested';


        showPlaceholders();

       // First ajax query to load latest games

        fetch(gamestore_params.ajaxurl, {
            method: 'POST',
            // contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },  
            body: new URLSearchParams({
                action: 'load_latest_games'
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Done');
                    renderGames(data.data);
                }
            })
            .catch(error => console.error('Error fetching latest games:', error));

        //Second ajax query to search games as user types

        searchInput.addEventListener('input', function () {
            const searchItem = searchInput.value;

            showPlaceholders();

            fetch(gamestore_params.ajaxurl, {
                method: 'POST',
                // contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'search_games_by_title',
                    search: searchItem
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        titleElement.textContent = 'Search Results';
                        console.log('Done');
                        renderGames(data.data);
                    }
                    else {
                        console.log('error');
                        titleElement.textContent = 'Nothing was found. You might be interested in';
                        showPlaceholders();
                        loadDefaultGames();
                    }
                })
                .catch(error => {
                    console.error('Error fetching latest games:', error);
                    console.log(response);
                });

        });
    });


    closeButton.addEventListener('click', function () {
        searchContainer.style.display = 'none';
    });

    function showPlaceholders() {
        searchResults.innerHtML = '';
        for (let i = 0; i < 12; i++) {
            const placeholder = document.createElement('div');
            placeholder.className = 'game-placeholder';
            searchResults.appendChild(placeholder);
        }
    }

    function renderGames(games) {
        console.log(games);
        searchResults.innerHTML = '';
        games.forEach(function (game) {
            const gameDiv = document.createElement('div');
            gameDiv.className = 'game-result';
            gameDiv.innerHTML = `
            <a href="${game.link}">
                <div class = "game-featured-image">${game.thumbnail}</div>
                <div class="game-meta">  
                    <div class="game-price">${game.price}</div>
                    <div class="game-title"><h3>${game.title}</h3></div>
                </div>
            </a>
        `;
            searchResults.appendChild(gameDiv);
        });
    }
    function loadDefaultGames() {
        fetch(gamestore_params.ajaxurl, {
            method: 'POST',
            // contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: new URLSearchParams({
                action: 'load_latest_games'
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Done');
                    renderGames(data.data);
                }
            })
            .catch(error => console.error('Error fetching latest games:', error));
    }
});


