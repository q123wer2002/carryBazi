<?php
include_once "Basetable.php";
	class UserInfo extends Basetable
	{
		//public area
		public function __set( $userid, $username, $email )
		{
			$this->m_userid = $userid;
			$this->m_username = $username;
			$this->m_email = $email;
		}

		public function getUSERID()
		{
			return $this->m_userid;
		}
		public function setUSERID( $id )
		{
			$this->m_userid = $id;
		}

		public function getUSERNAME()
		{
			return $this->m_username;
		}
		public function setUSERNAME( $name )
		{
			$this->m_username = $name;
		} 

		public function getEMAIL()
		{
			return $this->m_email;
		}
		public function setEMAIL( $email )
		{
			$this->m_email = $email;
		}

		public function getUPDATETIME()
		{
			return $this->m_updateDate;
		}
		public function setUPDATETIME( $updatetime )
		{
			$this->m_updateDate = $updatetime;
		}
		//protected area
		//private area
		private $m_userid = 0;
		private $m_username = "";
		private $m_email = "";
		private $m_updateDate = "";
	}
?>