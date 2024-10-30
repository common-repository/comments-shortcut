<?php

if (isset($_POST['action']))
{
	$action = $_POST['action'];
	if ($action == 'update')
	{
		$cmsc_instance->save_option_changes();
	}
}

?>

<div class="wrap">
  <h2><?php _e('Comments shortcut Options', 'Comments shortcut') ?></h2>
  <form method="post" action="">
	<table width="100%" cellspacing="2" cellpadding="5" class="form-table">
        <tr valign="baseline">
			<th scope="row"><?php _e('Text box ID') ?></th>
			<td>
				<input name="textarea_id" type="text" value="<?=$cmsc_instance->option['textarea_id']?>"/><br/>
				99% chance you won't change this.<br/>
				If this plugin doesn't work well, please check if this id is matched the '&lt;textarea id&gt;' in your page code.
			</td>
		</tr>
		<tr valign="baseline">
			<th scope="row"><?php _e('Sumbit button ID') ?></th>
			<td>
				<input name="submit_id" type="text" value="<?=$cmsc_instance->option['submit_id']?>"/><br/>
				99% chance you won't change this.<br/>
				If this plugin doesn't work well, please check if this id is matched the '&lt;input type="sumbit" id&gt;' in your page code.
			</td>
		</tr>
		<tr valign="baseline">
			<th scope="row"><?php _e('Accelerate key') ?></th>
			<td>
			<input name="accelerate_key" type="text" value="<?=$cmsc_instance->option['accelerate_key']?>"/><br/>
			Accelerate key is the code of a key on the keyboard.<br/>
			For example: Enter: 13, S: 155. You may found a full ascii code list <a href="http://en.wikipedia.org/wiki/ASCII#ASCII_printable_characters">here</a>
			</td>
		</tr>
		<tr valign="baseline">
			<th scope="row"><?php _e('Sumbit button append description') ?></th>
			<td>
				<input name="remind_text" type="text" value="<?=$cmsc_instance->option['remind_text']?>"/><br/>
				If you want to display some words to remind your commenters.
			</td>
		</tr>
	</table>
	<input type="hidden" name="action" value="update"/>
	<p class="submit">
      <input type="submit" value="<?php _e('Save Changes') ?>" />
    </p>
  </form>
</div>