<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sage Coding Round</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!--   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
 -->  <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/css/common.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<!--   <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
 --><!--   <script type="text/javascript" src="<?=BASE_URL?>/js/common.js"></script>
 -->  <!-- <script type="text/javascript" src="<?=BASE_URL?>/js/student.js"></script> -->
   <script src="<?php echo BASE_URL ?>/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo BASE_URL ?>/js/dataTables.bootstrap.min.js"></script>    
  <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/dataTables.bootstrap.min.css" />
  <script type="text/javascript">
      var APP_BASE_URL = "<?= BASE_URL ?>";
  </script>
  <script type="text/javascript" src="<?=BASE_URL?>/js/student.js"></script>
  <script type="text/javascript" src="<?=BASE_URL?>/js/course.js"></script>
  <script type="text/javascript" src="<?=BASE_URL?>/js/assignedCourse.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="https://sageintacct.com/sites/default/files/sage-intacct-logo.svg" ></a>
    </div>
    <ul class="nav navbar-nav">
        <?php
        $navArray = [
            [
                'name' => 'Manage Student',
                'url' => '/student/view'
            ],
            [
                'name' => 'Manage Course',
                'url' => '/course/view'
            ],
            [
                'name' => 'Assign Course (Reports)',
                'url' => '/assign/view'
            ]
        ];
        foreach ($navArray as $nav) {
            $class = '';
            if(REQUEST_URL == $nav['url']){
                $class = 'active';
            }
            echo '<li class="' . $class . '"><a href="' . BASE_URL . $nav['url'] . '">' . $nav['name'] . '</a></li>';
        }
        ?>
    </ul>
  </div>
</nav>

