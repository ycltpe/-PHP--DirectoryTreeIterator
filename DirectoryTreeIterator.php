<?php

class DirectoryTreeIterator extends DirectoryIterator
{
  private $iTotalBytes = null;
  private $aSubDirs = array();

  public function cumputeSize()
  {
    foreach($this as $index => $item)
    {
      if(!$item->isDot())
      {
        if($item->isDir())
        {
          $self = new self($item->getPathname());
          $this->iTotalBytes += $self->cumputeSize();
          
          $this->aSubDirs[$index] = $self;
        } else {
          $this->iTotalBytes += $item->getSize();
        }
      }
    }
    return $this->iTotalBytes;
  }
  
  public function getDirectoriesListing($iNesting = 0)
  {
    $sOut = '';
    $sMargin = str_repeat(' ', $iNesting);
    
    foreach($this as $item)
    {
      if(!$item->isDot() && $item->isDir())
      {
        $sOut .= $sMargin
                 .'|--'
                 .substr($item->getPath(), strrpos($item->getPath(), DIRECTORY_SEPARATOR)+1)
                 ."[{$item->iTotalBytes}]"
                 .PHP_EOL.$item->getDirectoriesListing($iNesting+2);
      }
    }
    return $sOut;
  }
  // ----------------- //
  // SETTERS & GETTERS //
  // ----------------- //
  public function getTotalSize() { return $this->iTotalBytes; }
  
  // ---------------- //
  // ITERATOR METHODS //
  // ---------------- //
  //private $iIndex = 0;
  public function current() { return isset($this->aSubDirs[$this->key()]) ? $this->aSubDirs[$this->key()] : parent::current(); }
  //public function next() { $this->iIndex += 1; }
  //public function key() { return $this->iIndex; }
  //public function rewind() { $this->iIndex = 0; }
  //public function valid() { return count($this->???) > $this->iIndex; }
}

?>