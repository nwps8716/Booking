<?PHP
class Config {
    
    public $projectName;
    public $root;
    public $imgRoot;
    public $cssRoot;
    public $jsRoot;
    
    public $db;
    
    function __construct(){
        $this->db['host']       = 'localhost';
        $this->db['port']       = '3306';
        $this->db['username']   = 'root';
        $this->db['password']   = '';
        $this->db['dbname']     = 'booking';
    }
}
?>