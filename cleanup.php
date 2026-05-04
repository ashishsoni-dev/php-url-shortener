<?php

require 'db.php';

// Delete expired links
mysqli_query($conn, "
    DELETE FROM urls 
    WHERE expires_at IS NOT NULL 
    AND expires_at < NOW()
");

// Delete links which aren't used in 30 days

mysqli_query($conn, "DELETE FROM urls WHERE (last_clicked_at IS NULL AND created_at < NOW() - INTERVAL 30 DAY) OR (last_clicked_at < NOW() - INTERVAL 30 DAY)");

echo "Cleanup done";
