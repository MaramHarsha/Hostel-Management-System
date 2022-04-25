<?php
class App extends CI_Controller {
	function gmsOptions()
    {
		$this->load->model('admin_model');
        $optionsres = $this->admin_model->loadOptions();
        foreach ($optionsres as $row)
        {
                $gmsopt[$row['opt_key']] = $row['opt_value'];
        }
        return $gmsopt;
	}
	
    function upgrade()
	{
		$this->load->database();
		$options = $this->gmsOptions();

		$sql = file_get_contents("assets/migration.3.sql");

		$sqls = explode(';', $sql);
		array_pop($sqls);

		foreach($sqls as $statement){
			$statment = $statement . ";";
			$this->db->query($statement);   
		}
		
		echo 'Calgary HMS Upgraded to 3.0.1';

	}
}