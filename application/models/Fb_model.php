<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb_model extends CI_Model
{
	public function checkLogin($socialUniqueId)
	{
		$this->db->select("memberInfo.socialUniqueId");
		$this->db->from($this->config->item('MEMBERS_TABLE')." memberInfo");
		$this->db->where("memberInfo.socialUniqueId",$socialUniqueId);
		$query = $this->db->get();
        return $query->num_rows();
	}
	
	public function insertRow($tableName,$insertData)
	{
		if($this->checkLogin($insertData["socialUniqueId"])==0)
		{
			$this->db->insert($tableName,$insertData);
		}else{
			$socialUniqueId=$insertData["socialUniqueId"];
			$updateData["fullName"]=$insertData['fullName'];
			$updateData["emailId"]=$insertData['emailId'];
			$updateData["loginTime"]=$insertData["loginTime"];
			$updateData["pageCount"]=$insertData["pageCount"];
			$this->db->where("socialUniqueId",$socialUniqueId);
			$this->db->update($tableName,$updateData);
		}
	}
	
	public function checkFBPage($pageUId)
	{
		$this->db->select("pageInfo.pageUId");
		$this->db->from($this->config->item('MEMBER_PAGES_TABLE')." pageInfo");
		$this->db->where("pageInfo.pageUId",$pageUId);
		$query = $this->db->get();
        return $query->num_rows();
	}
	
	public function insertPageRow($tableName,$insertData)
	{
		if($this->checkFBPage($insertData["pageUId"])==0)
		{
			$this->db->insert($tableName,$insertData);
		}else{
			$pageUId=$insertData["pageUId"];
			$fbUserId=$insertData["fbUserId"];
			$updateData["pageName"]=$insertData['pageName'];
			$updateData["reviewCount"]=$insertData['reviewCount'];
			$this->db->where("pageUId",$pageUId);
			$this->db->where("fbUserId",$fbUserId);
			$this->db->update($tableName,$updateData);
		}
	}
}
?>