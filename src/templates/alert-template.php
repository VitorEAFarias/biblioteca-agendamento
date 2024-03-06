

<div id="alerts-template">
<?php foreach ($messages as $type => $message): ?>
  <div class="<?php echo $type ?> ls-dismissable">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    <?php echo $message[0] ?>
  </div>
<?php endforeach ?>
</div>