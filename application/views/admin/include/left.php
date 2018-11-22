<!--sidebar start-->
<?php

$action = $this->router->fetch_method();

if ($this->uri->segment(3) == "changepassword")
    $url = "home";
else
    $url = $this->uri->segment(2); ?>


    <aside>
        <div id="sidebar"  class="nav-collapse "> 
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
                <li> 
                    <a <?php echo $url == 'dashboard' ? 'class="active"' : '' ?> href="<?php echo base_url(); ?>admin/dashboard"> <i class="icon-dashboard"></i> <span>Dashboard</span> </a>
                </li>
                <li>
                    <a <?php echo $url == 'users' ? 'class="active"' : '' ?> href="<?php echo base_url(); ?>admin/users">
                    <i class="icon-user"></i><span>User Management</span></a>
                </li>
                <li>
                    <a <?php echo $url == 'pushnotification' ? 'class="active"' : '' ?> href="<?php echo base_url(); ?>admin/pushnotification">
                        <i class="fa fa-bell"></i>
                        <span>Push Notification</span>
                    </a>
                </li>
                 <li>
                    <a <?php echo $url == 'cms' ? 'class="active"' : '' ?> href="<?php echo base_url(); ?>admin/cms">
                        <i class="fa fa-list-alt"></i>
                        <span>CSM Management</span>
                    </a>
                </li>

                 <li class="sub-menu dcjq-parent-li">
                    <a  <?php echo ($url == 'setting') ? 'class="active"' : '' ?> href="#">
                        <i class="icon-user"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub">
                        <li>
                            <a <?php echo ($url == 'setting' && $action == 'edit_smtp') ? 'class="active"' : '' ?> href="<?php echo base_url(); ?>admin/setting/edit_smtp">
                                <i class="fa fa-circle-o"></i>
                                <span>SMTP</span>
                            </a>
                        </li>
                        <li>
                            <a <?php echo ($url == 'setting' && $action == 'edit_pushnotification_setting') ? 'class="active"' : '' ?> href="<?php echo base_url(); ?>admin/setting/edit_pushnotification_setting">
                                <i class="fa fa-circle-o"></i>
                                <span>Push Notification</span>
                            </a>
                        </li>
                    </ul>
                </li> 


            </ul>
            <!-- sidebar menu end--> 
        </div>
    </aside>

<!--sidebar end-->

<?php
/* Breadcrumbs logic */
// echo $current_url = $_SERVER['REQUEST_URI'];exit;
$current_url = $breadcrumb;
$first_partition = explode("admin/", $current_url);
$second_partition = explode("/", $first_partition[1]);

if (count($second_partition) > 0 && $second_partition[0] == "dashboard" && count($second_partition) == 1) 
{ // Dashboard
    $final_array = array();
} 
else if (count($second_partition) > 0 && $second_partition[0] == "dashboard" && count($second_partition) == 2) 
{ // Dashboard
    $final_array = array();
    $final_array[] = '<li><a href="' . base_url() . 'admin/dashboard"><i class="icon-home"></i> Home</a></li>';
    if ($second_partition[1] == "changepassword")
        $final_array[] = '<li class="active">' . ucfirst("Change Password") . '</li>';
    else
        $final_array[] = '<li class="active">' . ucfirst($second_partition[1]) . '</li>';
}
else 
{
    $final_array = array();
    $final_array[] = '<li><a href="' . base_url() . 'admin/dashboard"><i class="icon-home"></i> Home</a></li>';

    if (isset($second_partition[1])) 
    {
        //if($second_partition[0].indexOf("?"))

        if (strrpos($second_partition[0], "?")) 
        {
            $tt = explode("?", $second_partition[0]);

            $final_array[] = '<li><a href="' . base_url() . 'admin/' . $tt[0] . '">' . ucfirst($tt[0]) . '</a></li>';
        } 
        else 
        {

        }
        $str = "";
        if ($second_partition[1] == "edit" || $second_partition[1] == "add" || $second_partition[1] == "view") 
        {
            if ($second_partition[0] == "users") 
            {
                $str = " User";
            }

            $final_array[] = '<li class="active">' . ucfirst($second_partition[1]) . $str . '</li>';
        }
    } 
    else 
    {
        $final_array[] = '<li class="active">' . ucfirst($second_partition[0]) . '</li>';
    }
}
/* Breadcrumbs logic */
?>
<section id="main-content">
    <section class="wrapper">
        <?php
        if (count($final_array) > 0) {
            ?>
            <div class="row">
                <div class="col-lg-12"> 
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <?php
                        foreach ($final_array as $brow) {
                            echo $brow;
                        }
                        ?>
                    </ul>
                    <!--breadcrumbs end --> 
                </div>
            </div>
            <?php
        }
        ?>
