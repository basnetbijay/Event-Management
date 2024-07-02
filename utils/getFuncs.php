<?php
function getUser($conn, $email){
    $sql="SELECT * FROM Users WHERE email=?";
    $stmt=mysqli_prepare($conn, $sql);
    if ($stmt===false) {
        echo mysqli_error($conn);
    }else{
        mysqli_stmt_bind_param($stmt, "s", $email);
        if (mysqli_stmt_execute($stmt)) {
            $result=mysqli_stmt_get_result($stmt);
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
}
function getUserListings($conn, $user_id) {
    $listings = array();

    // Prepare SQL query
    $sql = "SELECT * FROM Items WHERE listed_by = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
        return null;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows as an associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $listings[] = $row;
        }

        mysqli_stmt_close($stmt);
        return $listings;
    } else {
        echo "Error executing query: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        return null;
    }
}

function getActiveListings($conn, $user_id) {
    $listings = array();
    $status = "Active";
    // Prepare SQL query
    $sql = "SELECT * FROM Items WHERE listed_by = ? && status = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
        return null;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "is", $user_id, $status);

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows as an associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $listings[] = $row;
        }

        mysqli_stmt_close($stmt);
        return $listings;
    } else {
        echo "Error executing query: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        return null;
    }
}

function getPendingListings($conn, $user_id) {
    $listings = array();
    $status = "Pending";
    // Prepare SQL query
    $sql = "SELECT * FROM Items WHERE listed_by = ? && status = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
        return null;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "is", $user_id, $status);

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows as an associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $listings[] = $row;
        }

        mysqli_stmt_close($stmt);
        return $listings;
    } else {
        echo "Error executing query: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        return null;
    }
}

function getRejectedListings($conn, $user_id) {
    $listings = array();
    $status = "Rejected";
    // Prepare SQL query
    $sql = "SELECT * FROM Items WHERE listed_by = ? && status = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
        return null;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "is", $user_id, $status);

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows as an associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $listings[] = $row;
        }

        mysqli_stmt_close($stmt);
        return $listings;
    } else {
        echo "Error executing query: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        return null;
    }
}
?>