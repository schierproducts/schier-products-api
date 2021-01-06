<?php


namespace SchierProducts\SchierProductApi\ProductResources;

/**
 * Class DocumentLibrary
 *
 * Provides links to various formats/languages of a document.
 *
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property string|null $pdf
 * @property string|null $pdf_french French translation of the PDF
 * @property string|null $pdf_spanish Spanish translation of the PDF
 * @property string|null $dwg DWG file format used in AutoCad
 */
class DocumentLibrary extends ProductResource
{
    const OBJECT_NAME = 'document-library';

}