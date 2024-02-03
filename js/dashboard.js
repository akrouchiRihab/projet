$(document).ready(function(){
    function updateTable(event) {
      if (event)
      {
        event.preventDefault();
      }
        var name = $('#name_input').val();
        var role = $('#role-select').val();
        var search_option = $('#search-select').val();
        $.ajax({
            method: 'POST',
            url: 'change_query.php',
            data: { name, role, search_option },
            success: function(response) {
                $("#showdata").html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
  
    $('#name_input').on("keyup", function(){
      updateTable();
    });
  
    $('#role-select').on("change", function(){
      updateTable();
    });
    $('#search-select').on("change", function(){
      updateTable();
    });
  });
  
  document.addEventListener('DOMContentLoaded', function () {
    var paginationLinks = document.querySelectorAll('.pagination-link');
  
    paginationLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            event.currentTarget.focus();
  
            // Store the scroll position before reloading
            sessionStorage.setItem('scrollPosition', window.scrollY);
  
            // Trigger the default link behavior after setting focus
            window.location.href = event.currentTarget.href;
        });
    });
  
    // Check for stored scroll position on page load and adjust
    var scrollPosition = sessionStorage.getItem('scrollPosition');
    if (scrollPosition) {
        // Reset the stored scroll position
        sessionStorage.removeItem('scrollPosition');
  
        // Adjust the scroll position
        window.scrollTo(0, parseInt(scrollPosition));
    }
  });
  
  
  
  
  
  
  