<?php
$page_title = "Profil";
$use_pt = "";
include "header.php";

Utils::website_prevent_non_logged_in_visits();
?>


<style>
  .border{
    border-bottom:1px solid #F1F1F1;
    margin-bottom:10px;
  }
  .main-secction{
/*    box-shadow: 10px 10px 10px;*/
  }
  .image-section{
    padding: 0px;
  }
  .image-section img{
    width: 100%;
    height:250px;
    position: relative;
  }
  .user-image{
    position: absolute;
    margin-top:-50px;
  }
  .user-left-part{
    margin: 0px;
  }
  .user-image img{
    width:100px;
    height:100px;
  }
  .user-profil-part{
    padding-bottom:30px;
    background-color:#FAFAFA;
  }
  .follow{    
    margin-top:70px;   
  }
  .user-detail-row{
    margin:0px; 
  }
  .user-detail-section2 p{
    font-size:12px;
    padding: 0px;
    margin: 0px;
  }
  .user-detail-section2{
    margin-top:10px;
  }
  .user-detail-section2 span{
    color:#7CBBC3;
    font-size: 20px;
  }
  .user-detail-section2 small{
    font-size:12px;
    color:#D3A86A;
  }
  .profile-right-section{
    padding: 20px 0px 10px 15px;
    background-color: #FFFFFF;  
  }
  .profile-right-section-row{
    margin: 0px;
  }
  .profile-header-section1 h1{
    font-size: 25px;
    margin: 0px;
  }
  .profile-header-section1 h5{
    color: #0062cc;
  }
  .req-btn{
    height:30px;
    font-size:12px;
  }
  .profile-tag{
    padding: 10px;
    border:1px solid #F6F6F6;
  }
  .profile-tag p{
    font-size: 12px;
    color:black;
  }
  .profile-tag i{
    color:#ADADAD;
    font-size: 20px;
  }
  .image-right-part{
    background-color: #FCFCFC;
    margin: 0px;
    padding: 5px;
  }
  .img-main-rightPart{
    background-color: #FCFCFC;
    margin-top: auto;
  }
  .image-right-detail{
    padding: 0px;
  }
  .image-right-detail p{
    font-size: 12px;
  }
  .image-right-detail a:hover{
    text-decoration: none;
  }
  .image-right img{
    width: 100%;
  }
  .image-right-detail-section2{
    margin: 0px;
  }
  .image-right-detail-section2 p{
    color:#38ACDF;
    margin:0px;
  }
  .image-right-detail-section2 span{
    color:#7F7F7F;
  }

  .nav-link{
    font-size: 1.2em;    
  }
</style>

<div class="container main-secction mb-5">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 image-section">
            <img src="/assets/checkout-bg.jpg">
        </div>
        <div class="row user-left-part">
            <div class="col-md-4 col-sm-3 col-xs-12 user-profil-part pull-left">
                <div class="row ">
                    <div class="col-md-12 col-md-12-sm-12 col-xs-12 user-image text-center">
                        <img src="<?php echo Utils::get_user_avatar_from_email($my_account["email"], 100, "robohash"); ?>" class="rounded-circle">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center">
                        <a href="https://gravatar.com" target="_blank" class="btn btn-primary btn-block follow">
                            <i class="fa fa-image"></i> Changer Photo <small>(Sur Gravatar)</small>
                        </a> 
                        <a class="btn btn-success btn-block" href="/change-password"><i class="fa fa-key"></i> Mot de passe</a>                               
                        <a class="btn btn-danger btn-block" href="/account-deactivation"><i class="fa fa-ban"></i> Désactivation du compte</a>                               
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-9 col-xs-12 pull-right profile-right-section">
                <div class="row profile-right-section-row">
                    <div class="col-md-12 profile-header mb-4">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6 profile-header-section1 pull-left">
                                <h1>
                                <?php
                                if (empty($my_account["first_name"]) || empty($my_account["last_name"])) {
                                    echo $my_account["user_name"];
                                } else {
                                    echo $my_account["first_name"] ." ". $my_account["last_name"];
                                }
                                ?>
                                </h1>
                                <h5><?php echo Utils::get_account_role_string($my_account["role"]); ?></h5>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-6 profile-header-section1 text-right pull-rigth">
                                <button class="btn btn-success btn-block"
                                        pt-get="api/render-profile-tab.php"
                                        pt-target="#form_id"><i class="fa fa-user-circle"></i> View</button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-6 profile-header-section1 text-right pull-rigth">
                                <button class="btn btn-primary btn-block"
                                        pt-get="api/render-profile-form.php"
                                        pt-target="#form_id"><i class="fa fa-edit"></i> Edit</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" id="form_id">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Nom d'utilisateur</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>@<?php echo $my_account["user_name"]; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>E-mail</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $my_account["email"]; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Prénom & Nom</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $my_account["first_name"]." ".$my_account["last_name"]; ?></p>
                                            </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tel</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><?php echo $my_account["phone"]; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Adresse</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><?php echo $my_account["address"]; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Sexe</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>
                                                    <?php 
                                                    if ($my_account["gender"] == "male") {
                                                        echo "Homme";
                                                    } else if ($my_account["gender"] == "female") {
                                                        echo "Femme"; 
                                                    }
                                                    ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Date de naissance</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><?php if (empty($my_account["birth_date"]) || $my_account["birth_date"] === '0000-00-00'){
                                                           // 0000-00-00
                                                           echo "Vide";
                                                        } else { echo $my_account["birth_date"]; } ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Date d'inscription</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>
                                                    <?php if (empty($my_account["register_date"]) || $my_account["register_date"] === '0000-00-00'){
                                                           // 0000-00-00
                                                           echo "Vide";
                                                        } else { echo $my_account["register_date"]; } ?></p>
                                                </div>
                                            </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include "footer.php"; ?>