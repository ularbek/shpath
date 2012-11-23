$(document).ready(function() {
    
    var books= []; // Array that will contain all books
    $(document).ready(function() {
    	// http request
           $.getJSON("bookList.php?callback=?", function(data) {
    	      $.each(data, function(i, val){
    		 books.push(val);
    	      });
    	alert(books) ;
            });
    });
    
});