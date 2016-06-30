<?php

namespace icelineLtd\icelineDocRenderBundle\Tests\Mocks; 

use Symfony\Component\HttpKernel\Log\LoggerInterface;


/**
 * MockLogger ~ maybe this should be called the AAARRRRGGGGHHHHLog, as you can't find your log output on the test VM, 
      or you have logged alot and used all disk  
 * 
 * @uses LoggerInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class MockLogger implements LoggerInterface
{
	public function emerg($message, array $context = array()) {
		if($context!=[]) {
			echo($message.' '. var_export($context, true));
		} else {
			echo("$message\n");
		}
		fflush(STDOUT);
	}

    public function crit($message, array $context = array()){
		return $this->emerg($message, $context);
	}

    public function err($message, array $context = array()){
		return $this->emerg($message, $context);
	}

    public function warn($message, array $context = array()){
		return $this->emerg($message, $context);
	}

   public function emergency($message, array $context = array()){
		return $this->emerg($message, $context);
	}



   public function alert($message, array $context = array()){
		return $this->emerg($message, $context);
	}



   public function critical($message, array $context = array()){
		return $this->emerg($message, $context);
	}



   public function error($message, array $context = array()){
		return $this->emerg($message, $context);
	}



   public function warning($message, array $context = array()){
		return $this->emerg($message, $context);
	}



   public function notice($message, array $context = array()){
		return $this->emerg($message, $context);
	}



   public function info($message, array $context = array()){
		return $this->emerg($message, $context);
	}



   public function debug($message, array $context = array()){
		return $this->emerg($message, $context);
	}



   public function log($level, $message, array $context = array()){
		return $this->emerg($message, $context);
	}



}
