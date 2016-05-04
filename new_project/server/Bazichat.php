<?php
include_once "Basetable.php";
	class Bazichat extends Basetable
	{
		//public area
		public function __set( $chatid, $sender, $receiver, $type, $content, $isRead )
		{
			$this->m_chatid = $chatid;
			$this->m_sender = $sender;
			$this->m_receiver = $receiver;
			$this->m_type = $type;
			$this->m_content = $content;
			$this->m_isRead = $isRead;
		}

		public function getCHATID()
		{
			return $this->m_chatid;
		}
		public function setCHATID( $id )
		{
			$this->m_chatid = $id;
		}

		public function getSENDER()
		{
			return $this->m_sender;
		}
		public function setSENDER( $sender )
		{
			$this->m_sender = $sender;
		}

		public function getRECEIVER()
		{
			return $this->m_receiver;
		}
		public function setRECEIVER( $receiver )
		{
			$this->m_receiver = $receiver;
		}

		public function getTYPE()
		{
			return $this->m_type;
		}
		public function setTYPE( $type )
		{
			$this->m_type = $type;
		}

		public function getCONTENT()
		{
			return $this->m_content;
		}
		public function setCONTENT( $content )
		{
			$this->m_content = $content;
		}

		public function getISREAD()
		{
			return $this->m_isRead;
		}
		public function setISREAD( $isRead )
		{
			$this->m_isRead = $isRead;
		}

		public function getPOSTDATE()
		{
			return $this->m_postDate;
		}
		public function setPOSTDATE( $postDate )
		{
			$this->m_postDate = $postDate;
		}

		//protected area
		//private area
		private $m_chatid = 0;
		private $m_sender = "";
		private $m_receiver = "";
		private $m_type = "";
		private $m_content = "";
		private $m_isRead = false;
		private $m_postDate = "";		
	}
?>