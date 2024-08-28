<?php
/**
 *
 */
namespace FishPig\ThemeApp\ViewModel;

class Image implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     *
     */
    public function convertToInlineTag(string $imageUrl, array $params = []): ?string
    {
        if (($file = $this->resolveFile($imageUrl)) === null) {
            return null;
        }

        if (($imageType = $this->getImageType(basename($file))) === null) {
            return null;
        }

        if ($imageType === 'svg') {
            return file_get_contents($file);
        }


        $paramsHtml = rtrim(' ' . implode(' ', array_map(
            fn($key, $value) => $key . '="' . $value . '"',
            array_keys($params),
            $params
        )));

        return sprintf(
            '<img src="%s"%s/>',
            $this->convertToInlineUrl($file),
            $paramsHtml
        );
    }

    /**
     *
     */
    public function convertToInlineUrl(string $imageUrl): ?string
    {
        if (($file = $this->resolveFile($imageUrl)) === null) {
            return null;
        }

        if (($imageType = $this->getImageType(basename($file))) === null) {
            return null;
        }

        if ($imageType === 'svg') {
            return null;
        }

        return sprintf(
            'data:image/%s;base64,%s',
            $imageType,
            base64_encode(file_get_contents($file))
        );
    }

    /**
     *
     */
    public function getSizeAttributes(string $input): ?array
    {
        if (($file = $this->resolveFile($input)) === null) {
            return null;
        }

        if (($info = getimagesize($file)) === false) {
            return null;
        }

        return ['width' => $info[0], 'height' => $info[1]];
    }

    /**
     *
     */
    public function getSizeAttributesHtml(string $input): ?string
    {
        if ($sizes = $this->getSizeAttributes($input)) {
            return implode(' ', array_map(
                function ($value, $type) {
                    return $type . '="' . $value . '"';
                },
                $sizes,
                array_keys($sizes)
            ));
        } else 

        return null;
    }

    /**
     *
     */
    private function resolveFile(string $path): ?string
    {
        if (strpos($path, '/media/') === 0) {
            $path = BP . '/pub' . $path;
        } elseif (strpos($path, 'https://') === 0 || strpos($path, 'http://') === 0) {
            $path = preg_replace('/^.*\/(media|static)\//', BP . '/pub/$1/', $path);
            $path = str_replace('/pub/pub/media/', '/pub/media/', $path);
            $path = str_replace('/pub/pub/static/', '/pub/static/', $path);
            $path = preg_replace('/\/static\/version[0-9]+\//', '/static/', $path);
        } elseif (strpos($path, 'media/') === 0) {
            $path = BP . '/pub/' . $path;
        } elseif (strpos($path, 'pub/') === 0) {
            $path = BP . '/' . $path;
        } else {
            echo $path . __LINE__;exit;
            throw new \InvalidArgumentException(
                sprintf(
                    'Cannot resolve path "%s" in %s',
                    $path,
                    __CLASS__
                )
            );
        }

        return is_file($path) ? $path : null;
    }

    /**
     *
     */
    private function getImageType(string $image): ?string
    {
        if (preg_match('/\.(png|jpg|jpeg|webp|svg)/', $image, $match)) {
            return str_replace('jpeg', 'jpg', $match[1]);
        }

        return null;
    }
}
