<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    include 'config.php';

    $itemId = $_POST['itemId'];
    $adminPassword = $_POST['adminPassword'];

    
    if ($adminPassword !== '1234') {
        
        echo "Admin password is incorrect.";
    } else {
      
       
        $deleteBillDetailsSql = "DELETE FROM bill_details WHERE itemId = ?";
        $deleteBillDetailsStmt = $conn->prepare($deleteBillDetailsSql);
        $deleteBillDetailsStmt->bind_param("i", $itemId);

        if ($deleteBillDetailsStmt->execute()) {
           
            $deleteItemSql = "DELETE FROM item WHERE itemId = ?";
            $deleteItemStmt = $conn->prepare($deleteItemSql);
            $deleteItemStmt->bind_param("i", $itemId);

            if ($deleteItemStmt->execute()) {
                echo "<script>
                        alert('Item deleted successfully.');
                        window.location.href = 'detailpage.php';
                      </script>";
            } else {
                echo "Error deleting item.";
            }
        } else {
            echo "Error deleting related bill details.";
        }

        $deleteBillDetailsStmt->close();
        $deleteItemStmt->close();
        $conn->close();
    }
} else {
    header("Location: deleteinventory.html");
    exit();
}
?>
