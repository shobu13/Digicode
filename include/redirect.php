<?php
function redirect($url, $time=3)
{
	//On v�rifie si aucune ent�te n'a d�j� �t� envoy�e
	if (!headers_sent())  {
		header("refresh: $time;url=$url"); // on redirige avec header si une ent�te a d�j� �t� envoy�e
		exit;
	}
	else
	{
		echo '<meta http-equiv="refresh" content="',$time,';url=',$url,'">'; // sinon on redirige avec un ent�te
	}
}
?>