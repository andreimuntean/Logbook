// Defines the SearchResult class.
var SearchResult = function(title, url) {
    this.title = title;
    this.url = url;
};

// Adds a search result.
function addView(searchResult) {
    var searchResultView = document.createElement("li");
    var searchResultLink = document.createElement("a");

    // Assigns the searchResult class to the searchResultLink element.
    searchResultLink.className = "searchResult";

    // Customizes the searchResultLink element.
    searchResultLink.href = searchResult.url;
    searchResultLink.innerHTML = searchResult.title;

    // Adds the search result.
    searchResultView.appendChild(searchResultLink);
    document.getElementsByClassName("searchResults")[0].appendChild(searchResultView);
}

// Creates a view for each search result and displays it.
function displayResults(searchResults) {
    searchResults.forEach(function(searchResult) {
        addView(searchResult);
    });
}

window.onload = function() {
    displayResults([new SearchResult("Logbook 1", "http://www.facebook.com/"), new SearchResult("My Recipes", "http://www.google.com/")]);
};
