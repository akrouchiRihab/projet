<?php 
    require_once './includes/db_connect.php';
    
    $role_search = "";
    $query = "";
    $role = "all";
    $search_option = "name";

    $itemsPerPage = 10;
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;

    if (isset($_POST['name']))
    {
        $query = $_POST['name'];
    }
    if (isset($_POST['role']))
    {
        $role = $_POST['role'];
    }
    if (isset($_POST['search_option']))
    {
        $search_option = $_POST['search_option'];
    }

    if ($role != "all")
    {
        $role_search = "Role LIKE '$role' AND";
    }

    $sql = "SELECT * FROM users WHERE " . $role_search;
    

    if ($search_option == "name" || $query == "")
    {
        $query_search = " (LastName LIKE '$query%' 
        OR FirstName LIKE '$query%' 
        OR CONCAT(FirstName, ' ', LastName) LIKE '$query%' 
        OR CONCAT(LastName, ' ', FirstName) LIKE '$query%')
        ";
    }
    else
    {
        if (!is_numeric($query))
        {
            $query = -1;
        }
        $query_search = " UserID = $query";
    }
    
    $sql .= $query_search;
    $sql .= " LIMIT $offset, $itemsPerPage";

    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        echo "<tr class='align-middle'>";
        echo "<td>" . $row['UserID'] . "</td>";
        echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td>" . $row['Role'] . "</td>";
        echo "<td class='text-center align-middle' ><button class='btn px-2 p-1 btn-outline-danger border-0' onclick='deleteUser(" . $row['UserID'] . ")'><i class='bi bi-trash-fill'></i></button></td>";
        echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No users found</td></tr>";
    }

    $sql = "SELECT COUNT(*) as total FROM users WHERE " . $role_search . $query_search;
    $result = $conn->query($sql);
    $totalItems = $result->fetch_assoc()['total'];
    $totalPages = ceil($totalItems / $itemsPerPage);

    echo '<tr><td colspan="5">';
    echo '<div class="d-flex justify-content-center my-2">';
    echo '<div>';
    echo '<span class="mx-2"><strong>page: </strong></span>';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a class="pagination-link rounded p-1 px-2 ';
        if ($currentPage == $i)
        {
            echo 'bg-success text-white d';
        }
        else
        {
            echo 'border bg-white text-black ';
        }
        echo '" href="?page=' . $i . '">' . $i . '</a> ';
    }
    echo '</div>';
    echo '</div>';
    echo '</td></tr>';
?>
