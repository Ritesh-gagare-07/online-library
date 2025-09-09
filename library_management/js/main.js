$(document).ready(function() {
    // Function to load categories
    function loadCategories() {
        $.ajax({
            url: 'ajax/get_categories.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(function(category) {
                        html += `<div class="category-card" data-id="${category.id}">
                                    <h3>${category.name}</h3>
                                    <p>Click here to display books</p>
                                </div>`;
                    });
                } else {
                    html = '<p>No categories found.</p>';
                }
                $('#categories').html(html);
            },
            error: function(xhr) {
                $('#categories').html('<p>Error loading categories.</p>');
            }
        });
    }

    // Load categories immediately on page load
    loadCategories();

    // Category card click → load books
    $('#categories').on('click', '.category-card', function() {
        let categoryId = $(this).data('id');

        $.ajax({
            url: 'ajax/get_books.php',
            method: 'GET',
            data: { category_id: categoryId },
            dataType: 'json',
            success: function(data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(function (book) {
                        html += `<div class="book-card" data-book-id="${book.id}">
                                    <br>
                                    <img src="${book.url}" alt="${book.title}">
                                    <h4>${book.title}</h4>
                                    <p>${book.author}</p>
                                    <button class="borrow-btn">Borrow</button>
                                    <br>
                                </div>`;
                    });
                } else {
                    html = '<p>No books found in this category.</p>';
                }
                $('#books').html(html);
            },
            error: function(xhr) {
                $('#books').html('<p>Error loading books.</p>');
            }
        });
    });
});




// code for getting books from db
$('#categories').on('click', '.category-card', function() {
    let categoryId = $(this).data('id');

    $.ajax({
        url: 'ajax/get_books.php',
        method: 'GET',
        data: { category_id: categoryId },
        dataType: 'json',
        success: function(data) {
            let html = '';
            if (data.length > 0) {
                data.forEach(function (book) {
    html += ` <div class="book-card" data-book-id="${book.id}">
    <br>
                <img src="${book.url}" alt="${book.title}">

            <h4>${book.title}</h4>
            <p>${book.author}</p>
            <button class="borrow-btn">Borrow</button>
            <br>
        </div>`;
                });
            } else {
                html = '<p>No books found in this category.</p>';
            }
            $('#books').html(html);
        },
        error: function(xhr) {
            $('#books').html('<p>Error loading books.</p>');
        }
    });
});

//  jQuery Click Handler for Borrow Button

$('#books').on('click', '.borrow-btn', function () {
    let bookId = $(this).closest('.book-card').data('book-id');

    $.ajax({
        url: 'ajax/borrow_book.php',
        method: 'POST',
        data: { book_id: bookId },
        dataType: 'json',
        success: function (response) {
            alert(response.message || response.error);
        },
        error: function () {
            alert('Error borrowing the book.');
        }
    });
});


function loadBorrowedBooks() {
    $.ajax({
        url: 'ajax/get_borrowed_books.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            let html = '';
            if (data.length > 0) {
                data.forEach(function(book) {
                    html += `
                        <div class="book-card">
                             <img src="${book.url}" alt="${book.title}">
                            <h4>${book.title}</h4>
                            <p>by ${book.author}</p>
                            <p>Borrowed: ${book.days_borrowed} days</p>
                            <p>Fine: ₹${book.fine}</p>
                            <button class="read-btn" data-url="${book.url}">Read Book</button>
                            <button class="return-btn" data-book-id="${book.id}">Return Book</button>
                        </div>`;
                });
            } else {
                html = '<p>No borrowed books found.</p>';
            }
            $('#borrowed-books').html(html);
        },
        error: function() {
            $('#borrowed-books').html('<p>Error loading borrowed books.</p>');
        }
    });
}

// On page load or when needed
loadBorrowedBooks();

// Read Book (Opens book in new tab or iframe)
$('#borrowed-books').on('click', '.read-btn', function() {
    let url = $(this).data('url');
    window.open(url, '_blank');
});

// Return Book Handler
$('#borrowed-books').on('click', '.return-btn', function() {
    let bookId = $(this).data('book-id');

    $.ajax({
        url: 'ajax/return_book.php',
        method: 'POST',
        data: { book_id: bookId },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            loadBorrowedBooks();
        },
        error: function() {
            alert('Error returning the book.');
        }
    });
});


$('#borrowed-books').on('click', '.pay-fine-btn', function() {
    let bookId = $(this).data('book-id');

    $.ajax({
        url: 'ajax/pay_fine.php',
        method: 'POST',
        data: { book_id: bookId },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            loadBorrowedBooks();
        }
    });
});
