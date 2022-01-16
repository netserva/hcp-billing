<?php

declare(strict_types=1);
/*
* FPDF                                                                         *
*                                                                              *
* Version: 1.7                                                                 *
* Date:    2011-06-18                                                          *
* Author:  Olivier PLATHEY                                                     *
*/

define('FPDF_VERSION', '1.7');

class FPDF
{
    public $page;               // current page number
public $n;                  // current object number
public $offsets;            // array of object offsets
public $buffer;             // buffer holding in-memory PDF
public $pages;              // array containing pages
public $state;              // current document state
public $compress;           // compression flag
public $k;                  // scale factor (number of points in user unit)
public $DefOrientation;     // default orientation
public $CurOrientation;     // current orientation
public $StdPageSizes;       // standard page sizes
public $DefPageSize;        // default page size
public $CurPageSize;        // current page size
public $PageSizes;          // used for pages with non default sizes or orientations
public $wPt;
    public $hPt;          // dimensions of current page in points
    public $w;
    public $h;              // dimensions of current page in user unit
public $lMargin;            // left margin
public $tMargin;            // top margin
public $rMargin;            // right margin
public $bMargin;            // page break margin
public $cMargin;            // cell margin
public $x;
    public $y;              // current position in user unit
public $lasth;              // height of last printed cell
public $LineWidth;          // line width in user unit
public $fontpath;           // path containing fonts
public $CoreFonts;          // array of core font names
public $fonts;              // array of used fonts
public $FontFiles;          // array of font files
public $diffs;              // array of encoding differences
public $FontFamily;         // current font family
public $FontStyle;          // current font style
public $underline;          // underlining flag
public $CurrentFont;        // current font info
public $FontSizePt;         // current font size in points
public $FontSize;           // current font size in user unit
public $DrawColor;          // commands for drawing color
public $FillColor;          // commands for filling color
public $TextColor;          // commands for text color
public $ColorFlag;          // indicates whether fill and text colors are different
public $ws;                 // word spacing
public $images;             // array of used images
public $PageLinks;          // array of links in pages
public $links;              // array of internal links
public $AutoPageBreak;      // automatic page breaking
public $PageBreakTrigger;   // threshold used to trigger page breaks
public $InHeader;           // flag set when processing header
public $InFooter;           // flag set when processing footer
public $ZoomMode;           // zoom display mode
public $LayoutMode;         // layout display mode
public $title;              // title
public $subject;            // subject
public $author;             // author
public $keywords;           // keywords
public $creator;            // creator
public $AliasNbPages;       // alias for total number of pages
public $PDFVersion;         // PDF version number

// Public methods
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        // Some checks
        $this->_dochecks();
        // Initialization of properties
        $this->page = 0;
        $this->n = 2;
        $this->buffer = '';
        $this->pages = [];
        $this->PageSizes = [];
        $this->state = 0;
        $this->fonts = [];
        $this->FontFiles = [];
        $this->diffs = [];
        $this->images = [];
        $this->links = [];
        $this->InHeader = false;
        $this->InFooter = false;
        $this->lasth = 0;
        $this->FontFamily = '';
        $this->FontStyle = '';
        $this->FontSizePt = 12;
        $this->underline = false;
        $this->DrawColor = '0 G';
        $this->FillColor = '0 g';
        $this->TextColor = '0 g';
        $this->ColorFlag = false;
        $this->ws = 0;
        // Font path
        if (defined('FPDF_FONTPATH')) {
            $this->fontpath = FPDF_FONTPATH;
            if ('/' != substr($this->fontpath, -1) && '\\' != substr($this->fontpath, -1)) {
                $this->fontpath .= '/';
            }
        } elseif (is_dir(dirname(__FILE__).'/font')) {
            $this->fontpath = dirname(__FILE__).'/font/';
        } else {
            $this->fontpath = '';
        }
        // Core fonts
        $this->CoreFonts = ['courier', 'helvetica', 'times', 'symbol', 'zapfdingbats'];
        // Scale factor
        if ('pt' == $unit) {
            $this->k = 1;
        } elseif ('mm' == $unit) {
            $this->k = 72 / 25.4;
        } elseif ('cm' == $unit) {
            $this->k = 72 / 2.54;
        } elseif ('in' == $unit) {
            $this->k = 72;
        } else {
            $this->Error('Incorrect unit: '.$unit);
        }
        // Page sizes
        $this->StdPageSizes = ['a3' => [841.89, 1190.55], 'a4' => [595.28, 841.89], 'a5' => [420.94, 595.28],
            'letter' => [612, 792], 'legal' => [612, 1008], ];
        $size = $this->_getpagesize($size);
        $this->DefPageSize = $size;
        $this->CurPageSize = $size;
        // Page orientation
        $orientation = strtolower($orientation);
        if ('p' == $orientation || 'portrait' == $orientation) {
            $this->DefOrientation = 'P';
            $this->w = $size[0];
            $this->h = $size[1];
        } elseif ('l' == $orientation || 'landscape' == $orientation) {
            $this->DefOrientation = 'L';
            $this->w = $size[1];
            $this->h = $size[0];
        } else {
            $this->Error('Incorrect orientation: '.$orientation);
        }
        $this->CurOrientation = $this->DefOrientation;
        $this->wPt = $this->w * $this->k;
        $this->hPt = $this->h * $this->k;
        // Page margins (1 cm)
        $margin = 28.35 / $this->k;
        $this->SetMargins($margin, $margin);
        // Interior cell margin (1 mm)
        $this->cMargin = $margin / 10;
        // Line width (0.2 mm)
        $this->LineWidth = .567 / $this->k;
        // Automatic page break
        $this->SetAutoPageBreak(true, 2 * $margin);
        // Default display mode
        $this->SetDisplayMode('default');
        // Enable compression
        $this->SetCompression(true);
        // Set default PDF version number
        $this->PDFVersion = '1.3';
    }

    public function SetMargins($left, $top, $right = null): void
    {
        // Set left, top and right margins
        $this->lMargin = $left;
        $this->tMargin = $top;
        if (null === $right) {
            $right = $left;
        }
        $this->rMargin = $right;
    }

    public function SetLeftMargin($margin): void
    {
        // Set left margin
        $this->lMargin = $margin;
        if ($this->page > 0 && $this->x < $margin) {
            $this->x = $margin;
        }
    }

    public function SetTopMargin($margin): void
    {
        // Set top margin
        $this->tMargin = $margin;
    }

    public function SetRightMargin($margin): void
    {
        // Set right margin
        $this->rMargin = $margin;
    }

    public function SetAutoPageBreak($auto, $margin = 0): void
    {
        // Set auto page break mode and triggering margin
        $this->AutoPageBreak = $auto;
        $this->bMargin = $margin;
        $this->PageBreakTrigger = $this->h - $margin;
    }

    public function SetDisplayMode($zoom, $layout = 'default'): void
    {
        // Set display mode in viewer
        if ('fullpage' == $zoom || 'fullwidth' == $zoom || 'real' == $zoom || 'default' == $zoom || !is_string($zoom)) {
            $this->ZoomMode = $zoom;
        } else {
            $this->Error('Incorrect zoom display mode: '.$zoom);
        }
        if ('single' == $layout || 'continuous' == $layout || 'two' == $layout || 'default' == $layout) {
            $this->LayoutMode = $layout;
        } else {
            $this->Error('Incorrect layout display mode: '.$layout);
        }
    }

    public function SetCompression($compress): void
    {
        // Set page compression
        if (function_exists('gzcompress')) {
            $this->compress = $compress;
        } else {
            $this->compress = false;
        }
    }

    public function SetTitle($title, $isUTF8 = false): void
    {
        // Title of document
        if ($isUTF8) {
            $title = $this->_UTF8toUTF16($title);
        }
        $this->title = $title;
    }

    public function SetSubject($subject, $isUTF8 = false): void
    {
        // Subject of document
        if ($isUTF8) {
            $subject = $this->_UTF8toUTF16($subject);
        }
        $this->subject = $subject;
    }

    public function SetAuthor($author, $isUTF8 = false): void
    {
        // Author of document
        if ($isUTF8) {
            $author = $this->_UTF8toUTF16($author);
        }
        $this->author = $author;
    }

    public function SetKeywords($keywords, $isUTF8 = false): void
    {
        // Keywords of document
        if ($isUTF8) {
            $keywords = $this->_UTF8toUTF16($keywords);
        }
        $this->keywords = $keywords;
    }

    public function SetCreator($creator, $isUTF8 = false): void
    {
        // Creator of document
        if ($isUTF8) {
            $creator = $this->_UTF8toUTF16($creator);
        }
        $this->creator = $creator;
    }

    public function AliasNbPages($alias = '{nb}'): void
    {
        // Define an alias for total number of pages
        $this->AliasNbPages = $alias;
    }

    public function Error($msg): void
    {
        // Fatal error
        exit('<b>FPDF error:</b> '.$msg);
    }

    public function Open(): void
    {
        // Begin document
        $this->state = 1;
    }

    public function Close(): void
    {
        // Terminate document
        if (3 == $this->state) {
            return;
        }
        if (0 == $this->page) {
            $this->AddPage();
        }
        // Page footer
        $this->InFooter = true;
        $this->Footer();
        $this->InFooter = false;
        // Close page
        $this->_endpage();
        // Close document
        $this->_enddoc();
    }

    public function AddPage($orientation = '', $size = ''): void
    {
        // Start a new page
        if (0 == $this->state) {
            $this->Open();
        }
        $family = $this->FontFamily;
        $style = $this->FontStyle.($this->underline ? 'U' : '');
        $fontsize = $this->FontSizePt;
        $lw = $this->LineWidth;
        $dc = $this->DrawColor;
        $fc = $this->FillColor;
        $tc = $this->TextColor;
        $cf = $this->ColorFlag;
        if ($this->page > 0) {
            // Page footer
            $this->InFooter = true;
            $this->Footer();
            $this->InFooter = false;
            // Close page
            $this->_endpage();
        }
        // Start new page
        $this->_beginpage($orientation, $size);
        // Set line cap style to square
        $this->_out('2 J');
        // Set line width
        $this->LineWidth = $lw;
        $this->_out(sprintf('%.2F w', $lw * $this->k));
        // Set font
        if ($family) {
            $this->SetFont($family, $style, $fontsize);
        }
        // Set colors
        $this->DrawColor = $dc;
        if ('0 G' != $dc) {
            $this->_out($dc);
        }
        $this->FillColor = $fc;
        if ('0 g' != $fc) {
            $this->_out($fc);
        }
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
        // Page header
        $this->InHeader = true;
        $this->Header();
        $this->InHeader = false;
        // Restore line width
        if ($this->LineWidth != $lw) {
            $this->LineWidth = $lw;
            $this->_out(sprintf('%.2F w', $lw * $this->k));
        }
        // Restore font
        if ($family) {
            $this->SetFont($family, $style, $fontsize);
        }
        // Restore colors
        if ($this->DrawColor != $dc) {
            $this->DrawColor = $dc;
            $this->_out($dc);
        }
        if ($this->FillColor != $fc) {
            $this->FillColor = $fc;
            $this->_out($fc);
        }
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
    }

    public function Header(): void
    {
        // To be implemented in your own inherited class
    }

    public function Footer(): void
    {
        // To be implemented in your own inherited class
    }

    public function PageNo()
    {
        // Get current page number
        return $this->page;
    }

    public function SetDrawColor($r, $g = null, $b = null): void
    {
        // Set color for all stroking operations
        if ((0 == $r && 0 == $g && 0 == $b) || null === $g) {
            $this->DrawColor = sprintf('%.3F G', $r / 255);
        } else {
            $this->DrawColor = sprintf('%.3F %.3F %.3F RG', $r / 255, $g / 255, $b / 255);
        }
        if ($this->page > 0) {
            $this->_out($this->DrawColor);
        }
    }

    public function SetFillColor($r, $g = null, $b = null): void
    {
        // Set color for all filling operations
        if ((0 == $r && 0 == $g && 0 == $b) || null === $g) {
            $this->FillColor = sprintf('%.3F g', $r / 255);
        } else {
            $this->FillColor = sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        }
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
        if ($this->page > 0) {
            $this->_out($this->FillColor);
        }
    }

    public function SetTextColor($r, $g = null, $b = null): void
    {
        // Set color for text
        if ((0 == $r && 0 == $g && 0 == $b) || null === $g) {
            $this->TextColor = sprintf('%.3F g', $r / 255);
        } else {
            $this->TextColor = sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        }
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
    }

    public function GetStringWidth($s)
    {
        // Get width of a string in the current font
        $s = (string) $s;
        $cw = &$this->CurrentFont['cw'];
        $w = 0;
        $l = strlen($s);
        for ($i = 0; $i < $l; ++$i) {
            $w += $cw[$s[$i]];
        }

        return $w * $this->FontSize / 1000;
    }

    public function SetLineWidth($width): void
    {
        // Set line width
        $this->LineWidth = $width;
        if ($this->page > 0) {
            $this->_out(sprintf('%.2F w', $width * $this->k));
        }
    }

    public function Line($x1, $y1, $x2, $y2): void
    {
        // Draw a line
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F l S', $x1 * $this->k, ($this->h - $y1) * $this->k, $x2 * $this->k, ($this->h - $y2) * $this->k));
    }

    public function Rect($x, $y, $w, $h, $style = ''): void
    {
        // Draw a rectangle
        if ('F' == $style) {
            $op = 'f';
        } elseif ('FD' == $style || 'DF' == $style) {
            $op = 'B';
        } else {
            $op = 'S';
        }
        $this->_out(sprintf('%.2F %.2F %.2F %.2F re %s', $x * $this->k, ($this->h - $y) * $this->k, $w * $this->k, -$h * $this->k, $op));
    }

    public function AddFont($family, $style = '', $file = ''): void
    {
        // Add a TrueType, OpenType or Type1 font
        $family = strtolower($family);
        if ('' == $file) {
            $file = str_replace(' ', '', $family).strtolower($style).'.php';
        }
        $style = strtoupper($style);
        if ('IB' == $style) {
            $style = 'BI';
        }
        $fontkey = $family.$style;
        if (isset($this->fonts[$fontkey])) {
            return;
        }
        $info = $this->_loadfont($file);
        $info['i'] = count($this->fonts) + 1;
        if (!empty($info['diff'])) {
            // Search existing encodings
            $n = array_search($info['diff'], $this->diffs);
            if (!$n) {
                $n = count($this->diffs) + 1;
                $this->diffs[$n] = $info['diff'];
            }
            $info['diffn'] = $n;
        }
        if (!empty($info['file'])) {
            // Embedded font
            if ('TrueType' == $info['type']) {
                $this->FontFiles[$info['file']] = ['length1' => $info['originalsize']];
            } else {
                $this->FontFiles[$info['file']] = ['length1' => $info['size1'], 'length2' => $info['size2']];
            }
        }
        $this->fonts[$fontkey] = $info;
    }

    public function SetFont($family, $style = '', $size = 0): void
    {
        // Select a font; size given in points
        if ('' == $family) {
            $family = $this->FontFamily;
        } else {
            $family = strtolower($family);
        }
        $style = strtoupper($style);
        if (str_contains($style, 'U')) {
            $this->underline = true;
            $style = str_replace('U', '', $style);
        } else {
            $this->underline = false;
        }
        if ('IB' == $style) {
            $style = 'BI';
        }
        if (0 == $size) {
            $size = $this->FontSizePt;
        }
        // Test if font is already selected
        if ($this->FontFamily == $family && $this->FontStyle == $style && $this->FontSizePt == $size) {
            return;
        }
        // Test if font is already loaded
        $fontkey = $family.$style;
        if (!isset($this->fonts[$fontkey])) {
            // Test if one of the core fonts
            if ('arial' == $family) {
                $family = 'helvetica';
            }
            if (in_array($family, $this->CoreFonts)) {
                if ('symbol' == $family || 'zapfdingbats' == $family) {
                    $style = '';
                }
                $fontkey = $family.$style;
                if (!isset($this->fonts[$fontkey])) {
                    $this->AddFont($family, $style);
                }
            } else {
                $this->Error('Undefined font: '.$family.' '.$style);
            }
        }
        // Select it
        $this->FontFamily = $family;
        $this->FontStyle = $style;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        $this->CurrentFont = &$this->fonts[$fontkey];
        if ($this->page > 0) {
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
        }
    }

    public function SetFontSize($size): void
    {
        // Set font size in points
        if ($this->FontSizePt == $size) {
            return;
        }
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        if ($this->page > 0) {
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
        }
    }

    public function AddLink()
    {
        // Create a new internal link
        $n = count($this->links) + 1;
        $this->links[$n] = [0, 0];

        return $n;
    }

    public function SetLink($link, $y = 0, $page = -1): void
    {
        // Set destination of internal link
        if (-1 == $y) {
            $y = $this->y;
        }
        if (-1 == $page) {
            $page = $this->page;
        }
        $this->links[$link] = [$page, $y];
    }

    public function Link($x, $y, $w, $h, $link): void
    {
        // Put a link on the page
        $this->PageLinks[$this->page][] = [$x * $this->k, $this->hPt - $y * $this->k, $w * $this->k, $h * $this->k, $link];
    }

    public function Text($x, $y, $txt): void
    {
        // Output a string
        $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->underline && '' != $txt) {
            $s .= ' '.$this->_dounderline($x, $y, $txt);
        }
        if ($this->ColorFlag) {
            $s = 'q '.$this->TextColor.' '.$s.' Q';
        }
        $this->_out($s);
    }

    public function AcceptPageBreak()
    {
        // Accept automatic page break or not
        return $this->AutoPageBreak;
    }

    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = ''): void
    {
        // Output a cell
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
            // Automatic page break
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation, $this->CurPageSize);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(sprintf('%.3F Tw', $ws * $k));
            }
        }
        if (0 == $w) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $s = '';
        if ($fill || 1 == $border) {
            if ($fill) {
                $op = (1 == $border) ? 'B' : 'f';
            } else {
                $op = 'S';
            }
            $s = sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (str_contains($border, 'L')) {
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            }
            if (str_contains($border, 'T')) {
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            }
            if (str_contains($border, 'R')) {
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            }
            if (str_contains($border, 'B')) {
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            }
        }
        if ('' !== $txt) {
            if ('R' == $align) {
                $dx = $w - $this->cMargin - $this->GetStringWidth($txt);
            } elseif ('C' == $align) {
                $dx = ($w - $this->GetStringWidth($txt)) / 2;
            } else {
                $dx = $this->cMargin;
            }
            if ($this->ColorFlag) {
                $s .= 'q '.$this->TextColor.' ';
            }
            $txt2 = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
            $s .= sprintf('BT %.2F %.2F Td (%s) Tj ET', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $txt2);
            if ($this->underline) {
                $s .= ' '.$this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
            }
            if ($this->ColorFlag) {
                $s .= ' Q';
            }
            if ($link) {
                $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $this->GetStringWidth($txt), $this->FontSize, $link);
            }
        }
        if ($s) {
            $this->_out($s);
        }
        $this->lasth = $h;
        if ($ln > 0) {
            // Go to next line
            $this->y += $h;
            if (1 == $ln) {
                $this->x = $this->lMargin;
            }
        } else {
            $this->x += $w;
        }
    }

    public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false): void
    {
        // Output text with automatic or explicit line breaks
        $cw = &$this->CurrentFont['cw'];
        if (0 == $w) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && "\n" == $s[$nb - 1]) {
            --$nb;
        }
        $b = 0;
        if ($border) {
            if (1 == $border) {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            } else {
                $b2 = '';
                if (str_contains($border, 'L')) {
                    $b2 .= 'L';
                }
                if (str_contains($border, 'R')) {
                    $b2 .= 'R';
                }
                $b = (str_contains($border, 'T')) ? $b2.'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while ($i < $nb) {
            // Get next character
            $c = $s[$i];
            if ("\n" == $c) {
                // Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                ++$i;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                ++$nl;
                if ($border && 2 == $nl) {
                    $b = $b2;
                }

                continue;
            }
            if (' ' == $c) {
                $sep = $i;
                $ls = $l;
                ++$ns;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                // Automatic line break
                if (-1 == $sep) {
                    if ($i == $j) {
                        ++$i;
                    }
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                } else {
                    if ('J' == $align) {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    $this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                ++$nl;
                if ($border && 2 == $nl) {
                    $b = $b2;
                }
            } else {
                ++$i;
            }
        }
        // Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        if ($border && str_contains($border, 'B')) {
            $b .= 'B';
        }
        $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
        $this->x = $this->lMargin;
    }

    public function Write($h, $txt, $link = ''): void
    {
        // Output text in flowing mode
        $cw = &$this->CurrentFont['cw'];
        $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            // Get next character
            $c = $s[$i];
            if ("\n" == $c) {
                // Explicit line break
                $this->Cell($w, $h, substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                ++$i;
                $sep = -1;
                $j = $i;
                $l = 0;
                if (1 == $nl) {
                    $this->x = $this->lMargin;
                    $w = $this->w - $this->rMargin - $this->x;
                    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                }
                ++$nl;

                continue;
            }
            if (' ' == $c) {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                // Automatic line break
                if (-1 == $sep) {
                    if ($this->x > $this->lMargin) {
                        // Move to next line
                        $this->x = $this->lMargin;
                        $this->y += $h;
                        $w = $this->w - $this->rMargin - $this->x;
                        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                        ++$i;
                        ++$nl;

                        continue;
                    }
                    if ($i == $j) {
                        ++$i;
                    }
                    $this->Cell($w, $h, substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                } else {
                    $this->Cell($w, $h, substr($s, $j, $sep - $j), 0, 2, '', 0, $link);
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                if (1 == $nl) {
                    $this->x = $this->lMargin;
                    $w = $this->w - $this->rMargin - $this->x;
                    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                }
                ++$nl;
            } else {
                ++$i;
            }
        }
        // Last chunk
        if ($i != $j) {
            $this->Cell($l / 1000 * $this->FontSize, $h, substr($s, $j), 0, 0, '', 0, $link);
        }
    }

    public function Ln($h = null): void
    {
        // Line feed; default value is last cell height
        $this->x = $this->lMargin;
        if (null === $h) {
            $this->y += $this->lasth;
        } else {
            $this->y += $h;
        }
    }

    public function Image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = ''): void
    {
        // Put an image on the page
        if (!isset($this->images[$file])) {
            // First use of this image, get info
            if ('' == $type) {
                $pos = strrpos($file, '.');
                if (!$pos) {
                    $this->Error('Image file has no extension and no type was specified: '.$file);
                }
                $type = substr($file, $pos + 1);
            }
            $type = strtolower($type);
            if ('jpeg' == $type) {
                $type = 'jpg';
            }
            $mtd = '_parse'.$type;
            if (!method_exists($this, $mtd)) {
                $this->Error('Unsupported image type: '.$type);
            }
            $info = $this->{$mtd}($file);
            $info['i'] = count($this->images) + 1;
            $this->images[$file] = $info;
        } else {
            $info = $this->images[$file];
        }

        // Automatic width and height calculation if needed
        if (0 == $w && 0 == $h) {
            // Put image at 96 dpi
            $w = -96;
            $h = -96;
        }
        if ($w < 0) {
            $w = -$info['w'] * 72 / $w / $this->k;
        }
        if ($h < 0) {
            $h = -$info['h'] * 72 / $h / $this->k;
        }
        if (0 == $w) {
            $w = $h * $info['w'] / $info['h'];
        }
        if (0 == $h) {
            $h = $w * $info['h'] / $info['w'];
        }

        // Flowing mode
        if (null === $y) {
            if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
                // Automatic page break
                $x2 = $this->x;
                $this->AddPage($this->CurOrientation, $this->CurPageSize);
                $this->x = $x2;
            }
            $y = $this->y;
            $this->y += $h;
        }

        if (null === $x) {
            $x = $this->x;
        }
        $this->_out(sprintf('q %.2F 0 0 %.2F %.2F %.2F cm /I%d Do Q', $w * $this->k, $h * $this->k, $x * $this->k, ($this->h - ($y + $h)) * $this->k, $info['i']));
        if ($link) {
            $this->Link($x, $y, $w, $h, $link);
        }
    }

    public function GetX()
    {
        // Get x position
        return $this->x;
    }

    public function SetX($x): void
    {
        // Set x position
        if ($x >= 0) {
            $this->x = $x;
        } else {
            $this->x = $this->w + $x;
        }
    }

    public function GetY()
    {
        // Get y position
        return $this->y;
    }

    public function SetY($y): void
    {
        // Set y position and reset x
        $this->x = $this->lMargin;
        if ($y >= 0) {
            $this->y = $y;
        } else {
            $this->y = $this->h + $y;
        }
    }

    public function SetXY($x, $y): void
    {
        // Set x and y positions
        $this->SetY($y);
        $this->SetX($x);
    }

    public function Output($name = '', $dest = '')
    {
        // Output PDF to some destination
        if ($this->state < 3) {
            $this->Close();
        }
        $dest = strtoupper($dest);
        if ('' == $dest) {
            if ('' == $name) {
                $name = 'doc.pdf';
                $dest = 'I';
            } else {
                $dest = 'F';
            }
        }

        switch ($dest) {
        case 'I':
            // Send to standard output
            $this->_checkoutput();
            if (PHP_SAPI != 'cli') {
                // We send to a browser
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="'.$name.'"');
                header('Cache-Control: private, max-age=0, must-revalidate');
                header('Pragma: public');
            }
            echo $this->buffer;

            break;

        case 'D':
            // Download file
            $this->_checkoutput();
            header('Content-Type: application/x-download');
            header('Content-Disposition: attachment; filename="'.$name.'"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            echo $this->buffer;

            break;

        case 'F':
            // Save to local file
            $f = fopen($name, 'wb');
            if (!$f) {
                $this->Error('Unable to create output file: '.$name);
            }
            fwrite($f, $this->buffer, strlen($this->buffer));
            fclose($f);

            break;

        case 'S':
            // Return as a string
            return $this->buffer;

        default:
            $this->Error('Incorrect output destination: '.$dest);
    }

        return '';
    }

    // Protected methods
    public function _dochecks(): void
    {
        // Check availability of %F
        if ('1.0' != sprintf('%.1F', 1.0)) {
            $this->Error('This version of PHP is not supported');
        }
        // Check mbstring overloading
        if (ini_get('mbstring.func_overload') & 2) {
            $this->Error('mbstring overloading must be disabled');
        }
        // Ensure runtime magic quotes are disabled
        if (get_magic_quotes_runtime()) {
            @set_magic_quotes_runtime(0);
        }
    }

    public function _checkoutput(): void
    {
        if (PHP_SAPI != 'cli') {
            if (headers_sent($file, $line)) {
                $this->Error("Some data has already been output, can't send PDF file (output started at {$file}:{$line})");
            }
        }
        if (ob_get_length()) {
            // The output buffer is not empty
            if (preg_match('/^(\xEF\xBB\xBF)?\s*$/', ob_get_contents())) {
                // It contains only a UTF-8 BOM and/or whitespace, let's clean it
                ob_clean();
            } else {
                $this->Error("Some data has already been output, can't send PDF file");
            }
        }
    }

    public function _getpagesize($size)
    {
        if (is_string($size)) {
            $size = strtolower($size);
            if (!isset($this->StdPageSizes[$size])) {
                $this->Error('Unknown page size: '.$size);
            }
            $a = $this->StdPageSizes[$size];

            return [$a[0] / $this->k, $a[1] / $this->k];
        }

        if ($size[0] > $size[1]) {
            return [$size[1], $size[0]];
        }

        return $size;
    }

    public function _beginpage($orientation, $size): void
    {
        ++$this->page;
        $this->pages[$this->page] = '';
        $this->state = 2;
        $this->x = $this->lMargin;
        $this->y = $this->tMargin;
        $this->FontFamily = '';
        // Check page size and orientation
        if ('' == $orientation) {
            $orientation = $this->DefOrientation;
        } else {
            $orientation = strtoupper($orientation[0]);
        }
        if ('' == $size) {
            $size = $this->DefPageSize;
        } else {
            $size = $this->_getpagesize($size);
        }
        if ($orientation != $this->CurOrientation || $size[0] != $this->CurPageSize[0] || $size[1] != $this->CurPageSize[1]) {
            // New size or orientation
            if ('P' == $orientation) {
                $this->w = $size[0];
                $this->h = $size[1];
            } else {
                $this->w = $size[1];
                $this->h = $size[0];
            }
            $this->wPt = $this->w * $this->k;
            $this->hPt = $this->h * $this->k;
            $this->PageBreakTrigger = $this->h - $this->bMargin;
            $this->CurOrientation = $orientation;
            $this->CurPageSize = $size;
        }
        if ($orientation != $this->DefOrientation || $size[0] != $this->DefPageSize[0] || $size[1] != $this->DefPageSize[1]) {
            $this->PageSizes[$this->page] = [$this->wPt, $this->hPt];
        }
    }

    public function _endpage(): void
    {
        $this->state = 1;
    }

    public function _loadfont($font)
    {
        // Load a font definition file from the font directory
        include $this->fontpath.$font;
        $a = get_defined_vars();
        if (!isset($a['name'])) {
            $this->Error('Could not include font definition file');
        }

        return $a;
    }

    public function _escape($s)
    {
        // Escape special characters in strings
        $s = str_replace('\\', '\\\\', $s);
        $s = str_replace('(', '\\(', $s);
        $s = str_replace(')', '\\)', $s);

        return str_replace("\r", '\\r', $s);
    }

    public function _textstring($s)
    {
        // Format a text string
        return '('.$this->_escape($s).')';
    }

    public function _UTF8toUTF16($s)
    {
        // Convert UTF-8 to UTF-16BE with BOM
        $res = "\xFE\xFF";
        $nb = strlen($s);
        $i = 0;
        while ($i < $nb) {
            $c1 = ord($s[$i++]);
            if ($c1 >= 224) {
                // 3-byte character
                $c2 = ord($s[$i++]);
                $c3 = ord($s[$i++]);
                $res .= chr((($c1 & 0x0F) << 4) + (($c2 & 0x3C) >> 2));
                $res .= chr((($c2 & 0x03) << 6) + ($c3 & 0x3F));
            } elseif ($c1 >= 192) {
                // 2-byte character
                $c2 = ord($s[$i++]);
                $res .= chr(($c1 & 0x1C) >> 2);
                $res .= chr((($c1 & 0x03) << 6) + ($c2 & 0x3F));
            } else {
                // Single-byte character
                $res .= "\0".chr($c1);
            }
        }

        return $res;
    }

    public function _dounderline($x, $y, $txt)
    {
        // Underline text
        $up = $this->CurrentFont['up'];
        $ut = $this->CurrentFont['ut'];
        $w = $this->GetStringWidth($txt) + $this->ws * substr_count($txt, ' ');

        return sprintf('%.2F %.2F %.2F %.2F re f', $x * $this->k, ($this->h - ($y - $up / 1000 * $this->FontSize)) * $this->k, $w * $this->k, -$ut / 1000 * $this->FontSizePt);
    }

    public function _parsejpg($file)
    {
        // Extract info from a JPEG file
        $a = getimagesize($file);
        if (!$a) {
            $this->Error('Missing or incorrect image file: '.$file);
        }
        if (2 != $a[2]) {
            $this->Error('Not a JPEG file: '.$file);
        }
        if (!isset($a['channels']) || 3 == $a['channels']) {
            $colspace = 'DeviceRGB';
        } elseif (4 == $a['channels']) {
            $colspace = 'DeviceCMYK';
        } else {
            $colspace = 'DeviceGray';
        }
        $bpc = $a['bits'] ?? 8;
        $data = file_get_contents($file);

        return ['w' => $a[0], 'h' => $a[1], 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'DCTDecode', 'data' => $data];
    }

    public function _parsepng($file)
    {
        // Extract info from a PNG file
        $f = fopen($file, 'rb');
        if (!$f) {
            $this->Error('Can\'t open image file: '.$file);
        }
        $info = $this->_parsepngstream($f, $file);
        fclose($f);

        return $info;
    }

    public function _parsepngstream($f, $file)
    {
        // Check signature
        if ($this->_readstream($f, 8) != chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10)) {
            $this->Error('Not a PNG file: '.$file);
        }

        // Read header chunk
        $this->_readstream($f, 4);
        if ('IHDR' != $this->_readstream($f, 4)) {
            $this->Error('Incorrect PNG file: '.$file);
        }
        $w = $this->_readint($f);
        $h = $this->_readint($f);
        $bpc = ord($this->_readstream($f, 1));
        if ($bpc > 8) {
            $this->Error('16-bit depth not supported: '.$file);
        }
        $ct = ord($this->_readstream($f, 1));
        if (0 == $ct || 4 == $ct) {
            $colspace = 'DeviceGray';
        } elseif (2 == $ct || 6 == $ct) {
            $colspace = 'DeviceRGB';
        } elseif (3 == $ct) {
            $colspace = 'Indexed';
        } else {
            $this->Error('Unknown color type: '.$file);
        }
        if (0 != ord($this->_readstream($f, 1))) {
            $this->Error('Unknown compression method: '.$file);
        }
        if (0 != ord($this->_readstream($f, 1))) {
            $this->Error('Unknown filter method: '.$file);
        }
        if (0 != ord($this->_readstream($f, 1))) {
            $this->Error('Interlacing not supported: '.$file);
        }
        $this->_readstream($f, 4);
        $dp = '/Predictor 15 /Colors '.('DeviceRGB' == $colspace ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w;

        // Scan chunks looking for palette, transparency and image data
        $pal = '';
        $trns = '';
        $data = '';
        do {
            $n = $this->_readint($f);
            $type = $this->_readstream($f, 4);
            if ('PLTE' == $type) {
                // Read palette
                $pal = $this->_readstream($f, $n);
                $this->_readstream($f, 4);
            } elseif ('tRNS' == $type) {
                // Read transparency info
                $t = $this->_readstream($f, $n);
                if (0 == $ct) {
                    $trns = [ord(substr($t, 1, 1))];
                } elseif (2 == $ct) {
                    $trns = [ord(substr($t, 1, 1)), ord(substr($t, 3, 1)), ord(substr($t, 5, 1))];
                } else {
                    $pos = strpos($t, chr(0));
                    if (false !== $pos) {
                        $trns = [$pos];
                    }
                }
                $this->_readstream($f, 4);
            } elseif ('IDAT' == $type) {
                // Read image data block
                $data .= $this->_readstream($f, $n);
                $this->_readstream($f, 4);
            } elseif ('IEND' == $type) {
                break;
            } else {
                $this->_readstream($f, $n + 4);
            }
        } while ($n);

        if ('Indexed' == $colspace && empty($pal)) {
            $this->Error('Missing palette in '.$file);
        }
        $info = ['w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'FlateDecode', 'dp' => $dp, 'pal' => $pal, 'trns' => $trns];
        if ($ct >= 4) {
            // Extract alpha channel
            if (!function_exists('gzuncompress')) {
                $this->Error('Zlib not available, can\'t handle alpha channel: '.$file);
            }
            $data = gzuncompress($data);
            $color = '';
            $alpha = '';
            if (4 == $ct) {
                // Gray image
                $len = 2 * $w;
                for ($i = 0; $i < $h; ++$i) {
                    $pos = (1 + $len) * $i;
                    $color .= $data[$pos];
                    $alpha .= $data[$pos];
                    $line = substr($data, $pos + 1, $len);
                    $color .= preg_replace('/(.)./s', '$1', $line);
                    $alpha .= preg_replace('/.(.)/s', '$1', $line);
                }
            } else {
                // RGB image
                $len = 4 * $w;
                for ($i = 0; $i < $h; ++$i) {
                    $pos = (1 + $len) * $i;
                    $color .= $data[$pos];
                    $alpha .= $data[$pos];
                    $line = substr($data, $pos + 1, $len);
                    $color .= preg_replace('/(.{3})./s', '$1', $line);
                    $alpha .= preg_replace('/.{3}(.)/s', '$1', $line);
                }
            }
            unset($data);
            $data = gzcompress($color);
            $info['smask'] = gzcompress($alpha);
            if ($this->PDFVersion < '1.4') {
                $this->PDFVersion = '1.4';
            }
        }
        $info['data'] = $data;

        return $info;
    }

    public function _readstream($f, $n)
    {
        // Read n bytes from stream
        $res = '';
        while ($n > 0 && !feof($f)) {
            $s = fread($f, $n);
            if (false === $s) {
                $this->Error('Error while reading stream');
            }
            $n -= strlen($s);
            $res .= $s;
        }
        if ($n > 0) {
            $this->Error('Unexpected end of stream');
        }

        return $res;
    }

    public function _readint($f)
    {
        // Read a 4-byte integer from stream
        $a = unpack('Ni', $this->_readstream($f, 4));

        return $a['i'];
    }

    public function _parsegif($file)
    {
        // Extract info from a GIF file (via PNG conversion)
        if (!function_exists('imagepng')) {
            $this->Error('GD extension is required for GIF support');
        }
        if (!function_exists('imagecreatefromgif')) {
            $this->Error('GD has no GIF read support');
        }
        $im = imagecreatefromgif($file);
        if (!$im) {
            $this->Error('Missing or incorrect image file: '.$file);
        }
        imageinterlace($im, 0);
        $f = @fopen('php://temp', 'rb+');
        if ($f) {
            // Perform conversion in memory
            ob_start();
            imagepng($im);
            $data = ob_get_clean();
            imagedestroy($im);
            fwrite($f, $data);
            rewind($f);
            $info = $this->_parsepngstream($f, $file);
            fclose($f);
        } else {
            // Use temporary file
            $tmp = tempnam('.', 'gif');
            if (!$tmp) {
                $this->Error('Unable to create a temporary file');
            }
            if (!imagepng($im, $tmp)) {
                $this->Error('Error while saving to temporary file');
            }
            imagedestroy($im);
            $info = $this->_parsepng($tmp);
            unlink($tmp);
        }

        return $info;
    }

    public function _newobj(): void
    {
        // Begin a new object
        ++$this->n;
        $this->offsets[$this->n] = strlen($this->buffer);
        $this->_out($this->n.' 0 obj');
    }

    public function _putstream($s): void
    {
        $this->_out('stream');
        $this->_out($s);
        $this->_out('endstream');
    }

    public function _out($s): void
    {
        // Add a line to the document
        if (2 == $this->state) {
            $this->pages[$this->page] .= $s."\n";
        } else {
            $this->buffer .= $s."\n";
        }
    }

    public function _putpages(): void
    {
        $nb = $this->page;
        if (!empty($this->AliasNbPages)) {
            // Replace number of pages
            for ($n = 1; $n <= $nb; ++$n) {
                $this->pages[$n] = str_replace($this->AliasNbPages, $nb, $this->pages[$n]);
            }
        }
        if ('P' == $this->DefOrientation) {
            $wPt = $this->DefPageSize[0] * $this->k;
            $hPt = $this->DefPageSize[1] * $this->k;
        } else {
            $wPt = $this->DefPageSize[1] * $this->k;
            $hPt = $this->DefPageSize[0] * $this->k;
        }
        $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
        for ($n = 1; $n <= $nb; ++$n) {
            // Page
            $this->_newobj();
            $this->_out('<</Type /Page');
            $this->_out('/Parent 1 0 R');
            if (isset($this->PageSizes[$n])) {
                $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]', $this->PageSizes[$n][0], $this->PageSizes[$n][1]));
            }
            $this->_out('/Resources 2 0 R');
            if (isset($this->PageLinks[$n])) {
                // Links
                $annots = '/Annots [';
                foreach ($this->PageLinks[$n] as $pl) {
                    $rect = sprintf('%.2F %.2F %.2F %.2F', $pl[0], $pl[1], $pl[0] + $pl[2], $pl[1] - $pl[3]);
                    $annots .= '<</Type /Annot /Subtype /Link /Rect ['.$rect.'] /Border [0 0 0] ';
                    if (is_string($pl[4])) {
                        $annots .= '/A <</S /URI /URI '.$this->_textstring($pl[4]).'>>>>';
                    } else {
                        $l = $this->links[$pl[4]];
                        $h = isset($this->PageSizes[$l[0]]) ? $this->PageSizes[$l[0]][1] : $hPt;
                        $annots .= sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]>>', 1 + 2 * $l[0], $h - $l[1] * $this->k);
                    }
                }
                $this->_out($annots.']');
            }
            if ($this->PDFVersion > '1.3') {
                $this->_out('/Group <</Type /Group /S /Transparency /CS /DeviceRGB>>');
            }
            $this->_out('/Contents '.($this->n + 1).' 0 R>>');
            $this->_out('endobj');
            // Page content
            $p = ($this->compress) ? gzcompress($this->pages[$n]) : $this->pages[$n];
            $this->_newobj();
            $this->_out('<<'.$filter.'/Length '.strlen($p).'>>');
            $this->_putstream($p);
            $this->_out('endobj');
        }
        // Pages root
        $this->offsets[1] = strlen($this->buffer);
        $this->_out('1 0 obj');
        $this->_out('<</Type /Pages');
        $kids = '/Kids [';
        for ($i = 0; $i < $nb; ++$i) {
            $kids .= (3 + 2 * $i).' 0 R ';
        }
        $this->_out($kids.']');
        $this->_out('/Count '.$nb);
        $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]', $wPt, $hPt));
        $this->_out('>>');
        $this->_out('endobj');
    }

    public function _putfonts(): void
    {
        $nf = $this->n;
        foreach ($this->diffs as $diff) {
            // Encodings
            $this->_newobj();
            $this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences ['.$diff.']>>');
            $this->_out('endobj');
        }
        foreach ($this->FontFiles as $file => $info) {
            // Font file embedding
            $this->_newobj();
            $this->FontFiles[$file]['n'] = $this->n;
            $font = file_get_contents($this->fontpath.$file, true);
            if (!$font) {
                $this->Error('Font file not found: '.$file);
            }
            $compressed = ('.z' == substr($file, -2));
            if (!$compressed && isset($info['length2'])) {
                $font = substr($font, 6, $info['length1']).substr($font, 6 + $info['length1'] + 6, $info['length2']);
            }
            $this->_out('<</Length '.strlen($font));
            if ($compressed) {
                $this->_out('/Filter /FlateDecode');
            }
            $this->_out('/Length1 '.$info['length1']);
            if (isset($info['length2'])) {
                $this->_out('/Length2 '.$info['length2'].' /Length3 0');
            }
            $this->_out('>>');
            $this->_putstream($font);
            $this->_out('endobj');
        }
        foreach ($this->fonts as $k => $font) {
            // Font objects
            $this->fonts[$k]['n'] = $this->n + 1;
            $type = $font['type'];
            $name = $font['name'];
            if ('Core' == $type) {
                // Core font
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /'.$name);
                $this->_out('/Subtype /Type1');
                if ('Symbol' != $name && 'ZapfDingbats' != $name) {
                    $this->_out('/Encoding /WinAnsiEncoding');
                }
                $this->_out('>>');
                $this->_out('endobj');
            } elseif ('Type1' == $type || 'TrueType' == $type) {
                // Additional Type1 or TrueType/OpenType font
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /'.$name);
                $this->_out('/Subtype /'.$type);
                $this->_out('/FirstChar 32 /LastChar 255');
                $this->_out('/Widths '.($this->n + 1).' 0 R');
                $this->_out('/FontDescriptor '.($this->n + 2).' 0 R');
                if (isset($font['diffn'])) {
                    $this->_out('/Encoding '.($nf + $font['diffn']).' 0 R');
                } else {
                    $this->_out('/Encoding /WinAnsiEncoding');
                }
                $this->_out('>>');
                $this->_out('endobj');
                // Widths
                $this->_newobj();
                $cw = &$font['cw'];
                $s = '[';
                for ($i = 32; $i <= 255; ++$i) {
                    $s .= $cw[chr($i)].' ';
                }
                $this->_out($s.']');
                $this->_out('endobj');
                // Descriptor
                $this->_newobj();
                $s = '<</Type /FontDescriptor /FontName /'.$name;
                foreach ($font['desc'] as $k => $v) {
                    $s .= ' /'.$k.' '.$v;
                }
                if (!empty($font['file'])) {
                    $s .= ' /FontFile'.('Type1' == $type ? '' : '2').' '.$this->FontFiles[$font['file']]['n'].' 0 R';
                }
                $this->_out($s.'>>');
                $this->_out('endobj');
            } else {
                // Allow for additional types
                $mtd = '_put'.strtolower($type);
                if (!method_exists($this, $mtd)) {
                    $this->Error('Unsupported font type: '.$type);
                }
                $this->{$mtd}($font);
            }
        }
    }

    public function _putimages(): void
    {
        foreach (array_keys($this->images) as $file) {
            $this->_putimage($this->images[$file]);
            unset($this->images[$file]['data'], $this->images[$file]['smask']);
        }
    }

    public function _putimage(&$info): void
    {
        $this->_newobj();
        $info['n'] = $this->n;
        $this->_out('<</Type /XObject');
        $this->_out('/Subtype /Image');
        $this->_out('/Width '.$info['w']);
        $this->_out('/Height '.$info['h']);
        if ('Indexed' == $info['cs']) {
            $this->_out('/ColorSpace [/Indexed /DeviceRGB '.(strlen($info['pal']) / 3 - 1).' '.($this->n + 1).' 0 R]');
        } else {
            $this->_out('/ColorSpace /'.$info['cs']);
            if ('DeviceCMYK' == $info['cs']) {
                $this->_out('/Decode [1 0 1 0 1 0 1 0]');
            }
        }
        $this->_out('/BitsPerComponent '.$info['bpc']);
        if (isset($info['f'])) {
            $this->_out('/Filter /'.$info['f']);
        }
        if (isset($info['dp'])) {
            $this->_out('/DecodeParms <<'.$info['dp'].'>>');
        }
        if (isset($info['trns']) && is_array($info['trns'])) {
            $trns = '';
            for ($i = 0; $i < count($info['trns']); ++$i) {
                $trns .= $info['trns'][$i].' '.$info['trns'][$i].' ';
            }
            $this->_out('/Mask ['.$trns.']');
        }
        if (isset($info['smask'])) {
            $this->_out('/SMask '.($this->n + 1).' 0 R');
        }
        $this->_out('/Length '.strlen($info['data']).'>>');
        $this->_putstream($info['data']);
        $this->_out('endobj');
        // Soft mask
        if (isset($info['smask'])) {
            $dp = '/Predictor 15 /Colors 1 /BitsPerComponent 8 /Columns '.$info['w'];
            $smask = ['w' => $info['w'], 'h' => $info['h'], 'cs' => 'DeviceGray', 'bpc' => 8, 'f' => $info['f'], 'dp' => $dp, 'data' => $info['smask']];
            $this->_putimage($smask);
        }
        // Palette
        if ('Indexed' == $info['cs']) {
            $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
            $pal = ($this->compress) ? gzcompress($info['pal']) : $info['pal'];
            $this->_newobj();
            $this->_out('<<'.$filter.'/Length '.strlen($pal).'>>');
            $this->_putstream($pal);
            $this->_out('endobj');
        }
    }

    public function _putxobjectdict(): void
    {
        foreach ($this->images as $image) {
            $this->_out('/I'.$image['i'].' '.$image['n'].' 0 R');
        }
    }

    public function _putresourcedict(): void
    {
        $this->_out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
        $this->_out('/Font <<');
        foreach ($this->fonts as $font) {
            $this->_out('/F'.$font['i'].' '.$font['n'].' 0 R');
        }
        $this->_out('>>');
        $this->_out('/XObject <<');
        $this->_putxobjectdict();
        $this->_out('>>');
    }

    public function _putresources(): void
    {
        $this->_putfonts();
        $this->_putimages();
        // Resource dictionary
        $this->offsets[2] = strlen($this->buffer);
        $this->_out('2 0 obj');
        $this->_out('<<');
        $this->_putresourcedict();
        $this->_out('>>');
        $this->_out('endobj');
    }

    public function _putinfo(): void
    {
        $this->_out('/Producer '.$this->_textstring('FPDF '.FPDF_VERSION));
        if (!empty($this->title)) {
            $this->_out('/Title '.$this->_textstring($this->title));
        }
        if (!empty($this->subject)) {
            $this->_out('/Subject '.$this->_textstring($this->subject));
        }
        if (!empty($this->author)) {
            $this->_out('/Author '.$this->_textstring($this->author));
        }
        if (!empty($this->keywords)) {
            $this->_out('/Keywords '.$this->_textstring($this->keywords));
        }
        if (!empty($this->creator)) {
            $this->_out('/Creator '.$this->_textstring($this->creator));
        }
        $this->_out('/CreationDate '.$this->_textstring('D:'.@date('YmdHis')));
    }

    public function _putcatalog(): void
    {
        $this->_out('/Type /Catalog');
        $this->_out('/Pages 1 0 R');
        if ('fullpage' == $this->ZoomMode) {
            $this->_out('/OpenAction [3 0 R /Fit]');
        } elseif ('fullwidth' == $this->ZoomMode) {
            $this->_out('/OpenAction [3 0 R /FitH null]');
        } elseif ('real' == $this->ZoomMode) {
            $this->_out('/OpenAction [3 0 R /XYZ null null 1]');
        } elseif (!is_string($this->ZoomMode)) {
            $this->_out('/OpenAction [3 0 R /XYZ null null '.sprintf('%.2F', $this->ZoomMode / 100).']');
        }
        if ('single' == $this->LayoutMode) {
            $this->_out('/PageLayout /SinglePage');
        } elseif ('continuous' == $this->LayoutMode) {
            $this->_out('/PageLayout /OneColumn');
        } elseif ('two' == $this->LayoutMode) {
            $this->_out('/PageLayout /TwoColumnLeft');
        }
    }

    public function _putheader(): void
    {
        $this->_out('%PDF-'.$this->PDFVersion);
    }

    public function _puttrailer(): void
    {
        $this->_out('/Size '.($this->n + 1));
        $this->_out('/Root '.$this->n.' 0 R');
        $this->_out('/Info '.($this->n - 1).' 0 R');
    }

    public function _enddoc(): void
    {
        $this->_putheader();
        $this->_putpages();
        $this->_putresources();
        // Info
        $this->_newobj();
        $this->_out('<<');
        $this->_putinfo();
        $this->_out('>>');
        $this->_out('endobj');
        // Catalog
        $this->_newobj();
        $this->_out('<<');
        $this->_putcatalog();
        $this->_out('>>');
        $this->_out('endobj');
        // Cross-ref
        $o = strlen($this->buffer);
        $this->_out('xref');
        $this->_out('0 '.($this->n + 1));
        $this->_out('0000000000 65535 f ');
        for ($i = 1; $i <= $this->n; ++$i) {
            $this->_out(sprintf('%010d 00000 n ', $this->offsets[$i]));
        }
        // Trailer
        $this->_out('trailer');
        $this->_out('<<');
        $this->_puttrailer();
        $this->_out('>>');
        $this->_out('startxref');
        $this->_out($o);
        $this->_out('%%EOF');
        $this->state = 3;
    }
    // End of class
}

// Handle special IE contype request
if (isset($_SERVER['HTTP_USER_AGENT']) && 'contype' == $_SERVER['HTTP_USER_AGENT']) {
    header('Content-Type: application/pdf');

    exit;
}
