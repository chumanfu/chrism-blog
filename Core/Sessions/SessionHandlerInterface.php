<?php

namespace Core\Sessions;

interface SessionHandlerInterface
{
	public function startSession();
	public function getSessionValue($key, $default);
	public function setSessionValue($key, $value);
	public function sessionEnd();
}

?>