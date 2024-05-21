<?php
include 'conf/conf.php';

// Check if file is uploaded successfully
if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $file = $_FILES["file"]["tmp_name"];

    // Read CSV file
    if (($handle = fopen($file, "r")) !== FALSE) {
        // Prepare a statement for inserting data into database table
        $stmt = $conn->prepare("INSERT INTO Sampah (tahun, hari, timbulan_sampah) VALUES (?, ?, ?)");

        // Bind parameters to the prepared statement
        $stmt->bind_param("sss", $tahun, $hari, $timbulan_sampah);

        // Iterate through each row in CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Assign values from CSV to variables
            $tahun = $data[0];
            $hari = $data[1];
            $timbulan_sampah = $data[2];

            // Execute the prepared statement
            if (!$stmt->execute()) {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal melakukan import data!',
                        });
                     </script>";
                exit();
            }
        }

        // Close file handle and database connection
        fclose($handle);
        $stmt->close();
        $conn->close();

        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data CSV berhasil diimpor ke database.',
                    }).then(function() {
                        window.location.href = '?q=dataset';
                    });
             </script>";
        exit();
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal membaca file CSV!',
                });
             </script>";
    }
}