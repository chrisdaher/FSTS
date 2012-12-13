<?php
	class LogManager{
		private static $logFileDir = "/log/log.txt";
		public static function Log($string){
			self::$logFileDir = $_SERVER['DOCUMENT_ROOT'] . "/FSTS/log/log.txt";
			$myFile =  self::$logFileDir;
			$fh = fopen($myFile, 'a');
			if (!$fh){
				//not dev server
				self::$logFileDir = $_SERVER['DOCUMENT_ROOT'] . "/log/log.txt";
				$myFile =  self::$logFileDir;
				$fh = fopen($myFile, 'a');
				if (!$fh){
					echo ("Could not open log directory @ " . self::$logFileDir);
				}
			}
			if (!$fh) throw new Exception("Can't open log file");
			
			$backtrace = debug_backtrace();
			$final = "";
			for ($i=sizeof($backtrace)-1;$i>0;$i--){
				$temp = $backtrace[$i]['file'];
				$pos = strrpos($temp, "\\");
			
				$final = $final. substr($temp, $pos + 1, (strlen($temp) - $pos));
				if (($i-1) != 0){
					$final .= "::";
				}
			}
			$final = str_replace(".php","", $final);
			$str = $final . " || " . $string . "\n";
			fwrite($fh, $str);
			fclose($fh);
		}
		
		public static function LogCustom($string, $fileName){
			$myFile =  $_SERVER['DOCUMENT_ROOT'] . "/FSTS/log/" . $fileName;
			$fh = fopen($myFile, 'a') or die("can't open file");
			if (!$fh) throw new Exception("Can't open log file");
			
			$backtrace = debug_backtrace();
			$final = "";
			for ($i=sizeof($backtrace)-1;$i>0;$i--){
				$temp = $backtrace[$i]['file'];
				$pos = strrpos($temp, "\\");
			
				$final = $final. substr($temp, $pos + 1, (strlen($temp) - $pos));
				if (($i-1) != 0){
					$final .= "::";
				}
			}
			$final = str_replace(".php","", $final);
			$str = $final . " || " . $string . "\n";
			fwrite($fh, $str);
			fclose($fh);
		}
	}

?>