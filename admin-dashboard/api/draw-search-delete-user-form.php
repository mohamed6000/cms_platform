<form id="formAccountSettings" pt-post="api/delete-user.php" pt-target="target_form">
  <div class="row">
    <div class="col-md-12">
      <div id="result"></div>
    </div>
  
    <div class="col-md-6">
      <label for="user_id" class="form-label">Nom</label>
      <input class="form-control" type="text" id="user_id" name="user_id" autofocus=""
             pt-get="api/get-user-id.php" pt-event="input" pt-target="#select_user" pt-include>
    </div>

    <div class="col-md-12">
      <div id="select_user"></div>
    </div>
  </div>
  <div class="mt-2">
    <p>* L'utilisateur sera supprimé définitivement</p>
    <button type="submit" class="btn btn-primary me-2">Supprimer</button>
    <button type="reset" class="btn btn-outline-secondary">Annuler</button>
  </div>
</form>