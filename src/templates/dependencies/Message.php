
<?php foreach ($messages as $message): ?>
  <div class="<?php echo $message['status'] ?> ls-dismissable">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    <?php echo $message['text'] ?>
  </div>
<?php endforeach ?>