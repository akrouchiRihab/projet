function deleteUser(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
        // Send an AJAX request to the server to delete the user
        $.ajax({
            type: 'POST',
            url: 'delete_user.php', // Specify the path to your server-side script
            data: { userId: userId },
            success: function(response) {
                // Handle the response from the server
                alert(response);
                location.reload();
                // Optionally, you can update the UI or perform other actions here
            },
            error: function(error) {
                alert(error);
                location.reload();
            }
        });
    }
}