<?php
@$page = $_GET['q'];
if (!empty($page)) {
    switch ($page) {


        case 'beranda':
            include './pages/beranda/beranda.php';
            break;

            case 'chart':
                include './pages/chart/chart.php';
                break;

        case 'dataset':
            include './pages/dataset/dataset.php';
            break;

        case 'estimasi':
            include './pages/estimasi/estimasi.php';
            break;

        case 'hasil_estimasi':
            include './pages/hasil_estimasi/hasil_estimasi.php';
            break;
            
        case 'd_hasil_prediksi':
            include './pages/hasil_estimasi/d_hasil_prediksi/d_hasil_prediksi.php';
            break;

        case 'deleteall':
            include './pages/dataset/deleteall/deleteall.php';
            break;

        case 'add_data':
            include './pages/dataset/add_data/add_data.php';
            break;

        case 'delete_data':
            include './pages/dataset/delete_data/delete_data.php';
            break;

        case 'edit_data':
            include './pages/dataset/edit_data/edit_data.php';
            break;

        case 'editproses':
            include './pages/dataset/edit_data/editproses/editproses.php';
            break;

        case 'proses_csv':
            include './pages/dataset/proses_csv/proses_csv.php';
            break;
    }
} else {
    include './pages/beranda/beranda.php';
}