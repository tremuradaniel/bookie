const TIMEOUT = 600;
const MINIMUM_SEARCH_TERM_LENGTH = 3;
const ROWS_WITH_DISPLAY_INFO = 7;
const SEARCH_TERM_TOO_SHORT_ROW = "<div>Search term must have at least 3 characters.</div>";
const SEE_ENTIRE_RESULT_LIST_ROW = "<div><a href='#'>See all results.</a></div>";
let requestSent = false;
let searchTerm = "";

let autocomplete = () => {
  if ($("#nav-search").val().length < MINIMUM_SEARCH_TERM_LENGTH) {
    displaySearchTermTooShort();
    return;
  }

  if (!requestSent) {
    sendRequest();
  }
}

let searchValue = (searchKey) => {
  $.ajax({
    url: "search-book-author",
    type: "POST",
    dataType: "json",
    data: { "searchKey": searchKey },
    async: true,
    success: function (data)
    {
      populateResults(data);
    }
  });
}

let populateResults = (data) => {
  requestSent = false;
  let rows = createRows(data.data);
  clearQuickSearchResults();
  $("#quickSearchResults").append(rows);
  if (searchTerm !== $("#nav-search").val()) {
    autocomplete()
  }
} 

let createRows = (data) => {
  let result = "";

  if (data.length) {
    let i = 0;
    data.forEach(rowData => {
      i++;
      if (i <= ROWS_WITH_DISPLAY_INFO) {
        result += "<div><a href='"+ rowData.bookId +"'>" 
        + rowData.title + ", " + rowData.firstName + " " + rowData.lastName +"</a></div>";
      } else {
        result += SEE_ENTIRE_RESULT_LIST_ROW;
      }
    });
  } else {
    result += "<div>No results found.</div>";
  }
    
  return result;
}

let displaySearchTermTooShort = () => {
  clearQuickSearchResults();
  $("#quickSearchResults").append(SEARCH_TERM_TOO_SHORT_ROW);
}

// wait for the user to do some typing before sending the request
let sendRequest = () => {
  requestSent = true;
  setTimeout(function() {
    searchTerm = $("#nav-search").val();
    searchValue(searchTerm);
  }, TIMEOUT);
}

let clearQuickSearchResults = () => {
  $("#quickSearchResults").empty();
}

$("#nav-search").on("keyup", autocomplete);
$("#nav-search").blur(function() {
  clearQuickSearchResults();
});

$("#nav-search").focus(function() {
  autocomplete();
});