<?php
  $page_title = 'Editar cliente';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $client = find_by_id('client',(int)$_GET['id']);
  if(!$client){
    $session->msg("d","Missing client id.");
    redirect('client.php');
  }
?>

<?php
if(isset($_POST['edit_cat'])){
  $req_field = array('client-name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['client-name']));
  if(empty($errors)){
        $sql = "UPDATE client SET name='{$cat_name}'";
       $sql .= " WHERE id='{$client['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Categoría actualizada con éxito.");
       redirect('client.php',false);
     } else {
       $session->msg("d", "Lo siento, actualización falló.");
       redirect('client.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('client.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editando <?php echo remove_junk(ucfirst($client['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_client.php?id=<?php echo (int)$client['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="client-name" value="<?php echo remove_junk(ucfirst($client['name']));?>">
           </div>
           <button type="submit" name="edit_cat" class="btn btn-primary">Actualizar cliente</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
