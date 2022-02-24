const USER_BOOKS_CLASS = ".user-books";
let isLoading = true;
let currentBookShelve = "currently_reading";

console.log(LIST_USER_BOOKS_URL);
$(window).on("load", getUserBookShelve(currentBookShelve));
$(window).on("load", setEventOnBookShelvesSelect());
$(window).on("load", setEventOnSearchBook());


function getUserBookShelve(shelve) {
  console.log('testq');
  $.ajax({
      url: LIST_USER_BOOKS_URL + "/" + shelve,
      type: "POST",
      dataType: "json",
      async: true,
      success: function (data)
      {
        displayShelve(data);
      }
  });
}

function displayShelve(data) {
  $(".hourglass-container").hide();
  if (data.length) {
    // TO DO populate with user's books
  } else {
    $(USER_BOOKS_CLASS).append('<p>No books found for this shelve!');
    $(USER_BOOKS_CLASS).append(`
    <div class="container">
      <div class="row height d-flex justify-content-center align-items-center">
          <div class="col-md-8">
            <form action="/search-book" method="POST">
              <div class="search">
                <i class="fa fa-search"></i> <input name="search-term" id="search-input" type="text" class="form-control" placeholder="Search...">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="search-term-type" value="title" id="flexRadioTitle" checked>
                  <label class="form-check-label" for="flexRadioTitle">
                    Title
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="search-term-type" value="author" id="flexRadioAuthor">
                  <label class="form-check-label" for="flexRadioAuthor">
                    Author
                  </label>
                </div>
                <button id="search-book-button" class="btn btn-primary">Search</button> 
              </div>    
            </form>
          </div>
      </div>
    </div>
    `);
  }
} 


function setEventOnBookShelvesSelect() {
  $("#book-shelves").on("change", function() {
    if (this.value == currentBookShelve) return;
    currentBookShelve = this.value;
    $(USER_BOOKS_CLASS).empty();
    $(".hourglass-container").show();
    getUserBookShelve(currentBookShelve);
  });
}
