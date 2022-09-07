<?php

use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\GeneratorFactory;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Report\HtmlReport;
use Greenter\Report\PdfReport;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\Report\XmlUtils;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;

final class Util
{
    /**
     * @var Util
     */
    private static $current;
    private $ruc;
    private $usuario;
    private $clave;
    /**
     * @var SharedStore
     */
    public $shared;

    private function __construct()
    {
        $this->shared = new SharedStore();
    }

    /**
     * @return mixed
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * @param mixed $ruc
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public static function getInstance(): Util
    {
        if (!self::$current instanceof self) {
            self::$current = new self();
        }

        return self::$current;
    }

    public function getSee()
    {
        $see = new See();
        $see->setCertificate(file_get_contents(__DIR__ . '/../resources/c' . $this->ruc . '.pem'));
        $see->setService(SunatEndpoints::FE_BETA);
        $see->setClaveSOL($this->ruc, $this->usuario, $this->clave);

        return $see;
    }

    public function showResponse(DocumentInterface $document, CdrResponse $cdr): void
    {
        $filename = $document->getName();

        require __DIR__ . '/../views/response.php';
    }

    public function getErrorResponse(\Greenter\Model\Response\Error $error): string
    {
        $result = <<<HTML
        <h2 class="text-danger">Error:</h2><br>
        <b>Código:</b>{$error->getCode()}<br>
        <b>Descripción:</b>{$error->getMessage()}<br>
HTML;

        return $result;
    }

    public function writeXml(DocumentInterface $document, ?string $xml): void
    {
        $this->writeFile($document->getName() . '.xml', $xml);
    }

    public function writeCdr(DocumentInterface $document, ?string $zip): void
    {
        $this->writeFile('R-' . $document->getName() . '.zip', $zip);
    }

    public function writeFile(?string $filename, ?string $content): void
    {
        if (getenv('GREENTER_NO_FILES')) {
            return;
        }

        $fileDir = __DIR__ . '/../files';

        if (!file_exists($fileDir)) {
            mkdir($fileDir, 0777, true);
        }

        file_put_contents($fileDir . DIRECTORY_SEPARATOR . $filename, $content);
    }

    public function getPdf(DocumentInterface $document): ?string
    {
        $html = new HtmlReport('', [
            'cache' => __DIR__ . '/../cache',
            'strict_variables' => true,
        ]);
        $resolver = new DefaultTemplateResolver();
        $template = $resolver->getTemplate($document);
        $html->setTemplate($template);

        $render = new PdfReport($html);
        $render->setOptions([
            'no-outline',
            'print-media-type',
            'viewport-size' => '1280x1024',
            'page-width' => '21cm',
            'page-height' => '29.7cm',
            'footer-html' => __DIR__ . '/../resources/footer.html',
        ]);
        $binPath = self::getPathBin();
        if (file_exists($binPath)) {
            $render->setBinPath($binPath);
        }
        $hash = $this->getHash($document);
        $params = self::getParametersPdf();
        $params['system']['hash'] = $hash;
        $params['user']['footer'] = '<div>consulte en <a href="https://github.com/giansalex/sufel">sufel.com</a></div>';

        $pdf = $render->render($document, $params);

        if ($pdf === null) {
            $error = $render->getExporter()->getError();
            echo 'Error: ' . $error;
            exit();
        }

        // Write html
        $this->writeFile($document->getName() . '.html', $render->getHtml());

        return $pdf;
    }

    public function getGenerator(string $type): ?DocumentGeneratorInterface
    {
        $factory = new GeneratorFactory();
        $factory->shared = $this->shared;

        return $factory->create($type);
    }

    /**
     * @param SaleDetail $item
     * @param int $count
     * @return array<SaleDetail>
     */
    public function generator(SaleDetail $item, int $count): array
    {
        $items = [];

        for ($i = 0; $i < $count; $i++) {
            $items[] = $item;
        }

        return $items;
    }

    public function showPdf(?string $content, ?string $filename): void
    {
        $this->writeFile($filename, $content);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($content));

        echo $content;
    }

    public static function getPathBin(): string
    {
        $path = __DIR__ . '/../vendor/bin/wkhtmltopdf';
        if (self::isWindows()) {
            $path .= '.exe';
        }

        return $path;
    }

    public static function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    public function getHash($xml): ?string
    {
        return $hash = (new Greenter\Report\XmlUtils())->getHashSign($xml);
    }

    public function getHashXml($path)
    {
        $parser = new XmlReader();
        $archivoXml = file_get_contents($path);
        $documento = $parser->getDocument($archivoXml);
        $hash = $documento->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        return $hash;
    }

        /**
     * @return array<string, array>
     */
    private static function getParametersPdf(): array
    {
        $logo = file_get_contents(__DIR__ . '/../resources/logo.png');

        return [
            'system' => [
                'logo' => $logo,
                'hash' => ''
            ],
            'user' => [
                'resolucion' => '212321',
                'header' => 'Telf: <b>(056) 123375</b>',
                'extras' => [
                    ['name' => 'FORMA DE PAGO', 'value' => 'Contado'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
            ]
        ];
    }
}