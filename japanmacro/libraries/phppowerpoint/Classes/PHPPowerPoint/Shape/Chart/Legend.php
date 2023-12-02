<?php
/**
 * PHPPowerPoint
 *
 * Copyright (c) 2009 - 2010 PHPPowerPoint
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPPowerPoint
 * @package    PHPPowerPoint_Shape_Chart
 * @copyright  Copyright (c) 2009 - 2010 PHPPowerPoint (http://www.codeplex.com/PHPPowerPoint)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */


/**
 * PHPPowerPoint_Shape_Chart_Legend
 *
 * @category   PHPPowerPoint
 * @package    PHPPowerPoint_Shape_Chart
 * @copyright  Copyright (c) 2009 - 2010 PHPPowerPoint (http://www.codeplex.com/PHPPowerPoint)
 */
class PHPPowerPoint_Shape_Chart_Legend implements PHPPowerPoint_IComparable
{
	/** Legend positions */
	const POSITION_BOTTOM   = 'b';
	const POSITION_LEFT     = 'l';
	const POSITION_RIGHT    = 'r';
	const POSITION_TOP      = 't';
	const POSITION_TOPRIGHT = 'tr';
	
	/**
	 * Visible
	 *
	 * @var boolean
	 */
	private $_visible = true;

	/**
	 * Position
	 *
	 * @var string
	 */
	private $_position = PHPPowerPoint_Shape_Chart_Legend::POSITION_RIGHT;
	
	/**
	 * OffsetX (as a fraction of the chart)
	 *
	 * @var float
	 */
	private $_offsetX = 0;
	
	/**
	 * OffsetY (as a fraction of the chart)
	 *
	 * @var float
	 */
	private $_offsetY = 0;
	
	/**
	 * Width (as a fraction of the chart)
	 *
	 * @var float
	 */
	private $_width = 0;
	
	/**
	 * Height (as a fraction of the chart)
	 *
	 * @var float
	 */
	private $_height = 0;
    
	/**
	 * Font
	 *
	 * @var PHPPowerPoint_Style_Font
	 */
	private $_font;

	/**
	 * Border
	 *
	 * @var PHPPowerPoint_Style_Border
	 */
	private $_border;
	
	/**
	 * Fill
	 *
	 * @var PHPPowerPoint_Style_Fill
	 */
	private $_fill;
	
	/**
	 * Alignment
	 *
	 * @var PHPPowerPoint_Style_Alignment
	 */
	private $_alignment;
	
    /**
     * Create a new PHPPowerPoint_Shape_Chart_Legend instance
     */
    public function __construct()
    {
    	$this->_font = new PHPPowerPoint_Style_Font();
    	$this->_border = new PHPPowerPoint_Style_Border();
    	$this->_fill = new PHPPowerPoint_Style_Fill();
    	$this->_alignment = new PHPPowerPoint_Style_Alignment();
    }

	/**
	 * Get Visible
	 *
	 * @return boolean
	 */
	public function getVisible() {
	        return $this->_visible;
	}
	
	/**
	 * Set Visible
	 *
	 * @param boolean $value
	 * @return PHPPowerPoint_Shape_Chart_Legend
	 */
	public function setVisible($value = true) {
	        $this->_visible = $value;
	        return $this;
	}

	/**
	 * Get Position
	 *
	 * @return string
	 */
	public function getPosition() {
	        return $this->_position;
	}
	
	/**
	 * Set Position
	 *
	 * @param string $value
	 * @return PHPPowerPoint_Shape_Chart_Title
	 */
	public function setPosition($value = PHPPowerPoint_Shape_Chart_Legend::POSITION_RIGHT) {
	        $this->_position = $value;
	        return $this;
	}
	
	/**
	 * Get OffsetX (as a fraction of the chart)
	 *
	 * @return float
	 */
	public function getOffsetX() {
	        return $this->_offsetX;
	}
	
	/**
	 * Set OffsetX (as a fraction of the chart)
	 *
	 * @param float $value
	 * @return PHPPowerPoint_Shape_Chart_Legend
	 */
	public function setOffsetX($value = 0) {
	        $this->_offsetX = $value;
	        return $this;
	}
	
	/**
	 * Get OffsetY (as a fraction of the chart)
	 *
	 * @return float
	 */
	public function getOffsetY() {
	        return $this->_offsetY;
	}
	
	/**
	 * Set OffsetY (as a fraction of the chart)
	 *
	 * @param float $value
	 * @return PHPPowerPoint_Shape_Chart_Legend
	 */
	public function setOffsetY($value = 0) {
	        $this->_offsetY = $value;
	        return $this;
	}
	
	/**
	 * Get Width (as a fraction of the chart)
	 *
	 * @return float
	 */
	public function getWidth() {
	        return $this->_width;
	}
	
	/**
	 * Set Width (as a fraction of the chart)
	 *
	 * @param float $value
	 * @return PHPPowerPoint_Shape_Chart_Legend
	 */
	public function setWidth($value = 0) {
	        $this->_width = $value;
	        return $this;
	}
	
	/**
	 * Get Height (as a fraction of the chart)
	 *
	 * @return float
	 */
	public function getHeight() {
	        return $this->_height;
	}
	
	/**
	 * Set Height (as a fraction of the chart)
	 *
	 * @param float $value
	 * @return PHPPowerPoint_Shape_Chart_Legend
	 */
	public function setHeight($value = 0) {
	        $this->_height = $value;
	        return $this;
	}
	
	/**
	 * Get font
	 *
	 * @return PHPPowerPoint_Style_Font
	 */
	public function getFont() {
		return $this->_font;
	}

	/**
	 * Set font
	 *
	 * @param	PHPPowerPoint_Style_Font		$pFont		Font
	 * @throws 	Exception
	 * @return PHPPowerPoint_Shape_RichText_Paragraph
	 */
	public function setFont(PHPPowerPoint_Style_Font $pFont = null) {
		$this->_font = $pFont;
		return $this;
	}

    /**
     * Get Border
     *
     * @return PHPPowerPoint_Style_Border
     */
    public function getBorder() {
		return $this->_border;
    }
    
    /**
     * Get Fill
     *
     * @return PHPPowerPoint_Style_Fill
     */
    public function getFill() {
		return $this->_fill;
    }
    
    /**
     * Get alignment
     *
     * @return PHPPowerPoint_Style_Alignment
     */
    public function getAlignment()
    {
    	return $this->_alignment;
    }

    /**
     * Set alignment
     *
     * @param PHPPowerPoint_Style_Alignment		$alignment
     * @return PHPPowerPoint_Shape_RichText_Paragraph
     */
    public function setAlignment(PHPPowerPoint_Style_Alignment $alignment)
    {
    	$this->_alignment = $alignment;
    	return $this;
    }
	
	/**
	 * Get hash code
	 *
	 * @return string	Hash code
	 */
	public function getHashCode() {
    	return md5(
    		  $this->_position
    		. $this->_offsetX
    		. $this->_offsetY
    		. $this->_width
    		. $this->_height
    		. $this->_font->getHashCode()
    		. $this->_border->getHashCode()
    		. $this->_fill->getHashCode()
    		. $this->_alignment->getHashCode()
    		. ($this->_visible ? 't' : 'f')
    		. __CLASS__
    	);
    }

    /**
     * Hash index
     *
     * @var string
     */
    private $_hashIndex;

	/**
	 * Get hash index
	 *
	 * Note that this index may vary during script execution! Only reliable moment is
	 * while doing a write of a workbook and when changes are not allowed.
	 *
	 * @return string	Hash index
	 */
	public function getHashIndex() {
		return $this->_hashIndex;
	}

	/**
	 * Set hash index
	 *
	 * Note that this index may vary during script execution! Only reliable moment is
	 * while doing a write of a workbook and when changes are not allowed.
	 *
	 * @param string	$value	Hash index
	 */
	public function setHashIndex($value) {
		$this->_hashIndex = $value;
	}

	/**
	 * Implement PHP __clone to create a deep clone, not just a shallow copy.
	 */
	public function __clone() {
		$vars = get_object_vars($this);
		foreach ($vars as $key => $value) {
			if (is_object($value)) {
				$this->$key = clone $value;
			} else {
				$this->$key = $value;
			}
		}
	}
}