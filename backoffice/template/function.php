<?php
function inputText($text, $id, $class = '', $ml = '160', $value = '', $frm = '')
{
    echo '<div class="control-group">
			<label class="control-label" for="' . $id . '">' . $text . '</label>
			<div class="controls" style="margin-left:' . $ml . 'px;">
				<input name="' . $id . '" class="input-xlarge focused ' . $class . '" id="' . $id . '" type="text" value="' . $value . '" autocomplete="off">
			</div>
		</div>';
}

function inputPassword($text, $id, $class = '', $ml = '160', $value = '', $frm = '')
{
    echo '<div class="control-group">
			<label class="control-label" for="' . $id . '">' . $text . '</label>
			<div class="controls" style="margin-left:' . $ml . 'px;">
				<input name="' . $id . '" class="input-xlarge focused ' . $class . '" id="' . $id . '" type="password" value="' . $value . '">
			</div>
		</div>';
}

function inputHidden($text, $id)
{
    echo '<input type="hidden" name="' . $id . '" id="' . $id . '" vlaue="' . $text . '">';
}

function inputTextarea($text, $id, $class = '', $ml = '160', $value = '', $frm = '')
{
    echo '<div class="control-group">
			<label class="control-label" for="' . $id . '">' . $text . '</label>
			<div class="controls" style="margin-left:' . $ml . 'px;">
				<textarea name="' . $id . '" class="input-xlarge focused ' . $class . '" id="' . $id . '">' . $value . '</textarea>
			</div>
		</div>';
}

?>