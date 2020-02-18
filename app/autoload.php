<?php

function autoload($class)
{
	$class_inc = CORE . $class . '.php';

	if (file_exists($class_inc)) 
	{
		require_once($class_inc);
	}
	else
	{
		//Find class in other folders
		foreach (unserialize(AUTOLOAD) as $folder) 
		{
			$class_inc = $folder . $class;

			if(file_exists($class_inc))
			{
				require_once($class_inc);
			}
		}
	}
}


spl_autoload_register('autoload');