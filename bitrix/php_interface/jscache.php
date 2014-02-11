<?
class JSCache
{
	public $filename;
	public $ttl;
	public $arFiles;
	
	private $bCache = false;
	
	public function __construct($filename, $ttl = 36000)
	{
		global $USER;
		$ttl = intval($ttl);
		if(!$ttl)
			$ttl = 36000;
			
		$this -> ttl = $ttl;
		$this -> filename = $filename;
		
		if($USER -> IsAdmin() && isset($_REQUEST["clear_cache"]) && $_REQUEST["clear_cache"] == "Y")
			return;
		
		if(file_exists($_SERVER["DOCUMENT_ROOT"] . $filename) && (filemtime($_SERVER["DOCUMENT_ROOT"] . $filename) + $this -> ttl) > time())
		{
			$this -> bCache = true; 
			?>
			<script type="text/javascript" src="<?=$this -> filename;?>"></script>
			<?
		}
	}
	
	public function AddFile($file)
	{
		if($this -> bCache)
			return;
			
		if(file_exists($_SERVER["DOCUMENT_ROOT"] . $file))
			$this -> arFiles[$file] = $file;
	}
	
	public function End()
	{
		if($this -> bCache)
			return;
			
		$sLink = '';
		if(file_exists($_SERVER["DOCUMENT_ROOT"] . $this -> filename))
			unlink($_SERVER["DOCUMENT_ROOT"] . $this -> filename);
		if($f = @fopen($_SERVER["DOCUMENT_ROOT"] . $this -> filename, 'w'))
		{	
			foreach($this -> arFiles as $filename)
			{				
				fwrite($f, file_get_contents($_SERVER["DOCUMENT_ROOT"] . $filename) . "\r\n");
				$sLink = '<script type="text/javascript" src="' . $filename . '"></script>';
			}
			
			fclose($f);
			?>
			<script type="text/javascript" src="<?=$this -> filename;?>"></script>
			<?
			
			return;
		} else
		{
			foreach($this -> arFiles as $filename)
				$sLink .= '<script type="text/javascript" src="' . $filename . '"></script>';
		}
		
		echo $sLink;
	}
}
?>