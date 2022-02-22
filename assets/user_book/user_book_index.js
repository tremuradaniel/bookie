const USER_BOOKS_CLASS = ".user-books";
let isLoading = true;
let currentBookShelve = "currently_reading";

console.log(LIST_USER_BOOKS_URL);
$(window).on("load", getUserBookShelve(currentBookShelve));
$(window).on("load", setEventOnBookShelvesSelect());


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

  } else {
    $(USER_BOOKS_CLASS).append('<p>No books found for this shelve! <a href="#">Search your book here!</a></p>')
  }
} 


function setEventOnBookShelvesSelect() {
  $("#book-shelves").on("change", function() {
    if (this.value == currentBookShelve) return;
    currentBookShelve = this.value
    $(USER_BOOKS_CLASS).empty();
    $(".hourglass-container").show();
    getUserBookShelve(currentBookShelve)
  });
}