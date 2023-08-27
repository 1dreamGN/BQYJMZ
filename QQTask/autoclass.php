<?php
if ($qzone->sidzt or $qzone->skeyzt) {
		$db->query("UPDATE {$prefix}qqs SET skeyzt='1',sidzt='1' WHERE qid='{$qid}'");
}
?>