<?php
header("Content-Type:text/html;charset=utf8");   
class DB{
    private static $_instance;
    private $link;
    private $addr = 'localhost';
    private $login_id = 'root';
    private $password = 'ICUI4CUz3';
    private $dbname = 'nobita';

    public function __construct()
    {
        /* Connect to a MySQL server  连接数据库服务器 */   
        $this->link = mysqli_connect(   
                $this->addr,  /* The host to connect to 连接MySQL地址 */   
                $this->login_id,      /* The user to connect as 连接MySQL用户名 */   
                $this->password,  /* The password to use 连接MySQL密码 */   
                $this->dbname);    /* The default database to query 连接数据库名称*/

        mysqli_query($this->link,"set character set 'utf8'");//读库 
        mysqli_query($this->link,"set names 'utf8'");//写库
    }

    public function __destruct()
    {
        /* Close the connection 关闭连接*/   
        mysqli_close($this->link); 
    }

    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function sql($sql){
        if (!$this->link) {   
           printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());   
           exit;   
        }   
        
        $res = array();
       
        //print($sql."</br>");

        if ($result = mysqli_query($this->link, $sql)) {   
            
            //print("Results are: "."</br>");   
          
            /* Fetch the results of the query 返回查询的结果 */   
            while( $row = mysqli_fetch_assoc($result) ){   
                //printf("m_id: %d    name: %s"."</br>", $row['m_id'], $row['name']);
                array_push($res, $row);   
            }   
          
            /* Destroy the result set and free the memory used for it 结束查询释放内存 */   
            mysqli_free_result($result);
        } 
        return $res;
    }

    public function select($table_name,$cond = "1 = 1",$select = "*"){
        if (!$this->link) {   
           printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());   
           exit;   
        }   
        
        $res = array();
        /* Send a query to the server 向服务器发送查询请求*/   
        $sqlstr = 'SELECT '.$select.' FROM '.$table_name.' WHERE '.$cond;
        //print($sqlstr."</br>");

        if ($result = mysqli_query($this->link, $sqlstr)) {   
            
            //print("Results are: "."</br>");   
          
            /* Fetch the results of the query 返回查询的结果 */   
            while( $row = mysqli_fetch_assoc($result) ){   
                //printf("m_id: %d    name: %s"."</br>", $row['m_id'], $row['name']);
                array_push($res, $row);   
            }   
          
            /* Destroy the result set and free the memory used for it 结束查询释放内存 */   
            mysqli_free_result($result);
        } 
        return $res;
    }

    public function insert($table_name,$col,$value){
        if (!$this->link) {   
           printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());   
           exit;   
        }

        $sqlstr = 'INSERT INTO '.$table_name.'('.$col.') VALUES('.$value.')';
        //echo $sqlstr; 
        if($result = mysqli_query($this->link, $sqlstr)){
            return "插入成功";
        }         
        else{
            return "插入失败";
        }
    }

    public function update($table_name,$value,$cond){
        if (!$this->link) {   
           printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());   
           exit;   
        }

        $sqlstr = 'UPDATE '.$table_name.' SET '.$value.' WHERE '.$cond;
        //echo $sqlstr; 
        if($result = mysqli_query($this->link, $sqlstr)){
            return "修改成功";
        }         
        else{
            return "修改失败";
        }
    }

    public function delete($table_name,$cond){
        if (!$this->link) {   
           printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());   
           exit;   
        }

        $sqlstr = 'DELETE FROM '.$table_name.' WHERE '.$cond;
        //echo $sqlstr; 
        if($result = mysqli_query($this->link, $sqlstr)){
            return "删除成功";
        }         
        else{
            return "删除失败";
        }
    }

    public function printRes($result){
        foreach($result as $row){
            foreach($row as $field){
                print($field."   ");
            }
            print "</br>";
        }
    }
}  

//$test = new DB();

/*打印表数据
$manager = $test->select("manager");
print("Data from Manager:"."</br>");
$test->printRes($manager);

$clerk = $test->select("clerk");
print("Data from Clerk:"."</br>");
$test->printRes($clerk);*/

?> 