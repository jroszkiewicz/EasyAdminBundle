<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Property;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Property\PropertyConfigInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\AssetDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\PropertyDto;
use Symfony\Component\HttpFoundation\ParameterBag;

trait PropertyConfigTrait
{
    private $type;
    private $name;
    private $value;
    private $formattedValue;
    private $label;
    private $formType;
    private $formTypeOptions;
    private $sortable;
    private $virtual;
    private $permission;
    private $textAlign;
    private $help;
    private $cssClass;
    private $translationParams;
    private $templateName;
    private $templatePath;
    private $cssFiles;
    private $jsFiles;
    private $headContents;
    private $bodyContents;
    private $customOptions;
    private $processedCustomOptions;

    private function __construct()
    {
    }

    public static function new(string $name, ?string $label = null): PropertyConfigInterface
    {
        $property = new static();
        $property->name = $name;
        $property->label = $label;

        return $property;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the original unmodified value stored in the entity property.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the value to be displayed for the entity property (it could be the
     * same as the value stored in the property or not).
     */
    public function getFormattedValue()
    {
        return $this->formattedValue;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getFormType(): ?string
    {
        return $this->formType;
    }

    public function getFormTypeOptions(): array
    {
        return $this->formTypeOptions;
    }

    public function isSortable(): bool
    {
        return true === $this->sortable;
    }

    public function isVirtual(): bool
    {
        return true === $this->virtual;
    }

    public function getTextAlign(): ?string
    {
        return $this->textAlign;
    }

    public function getPermission(): ?string
    {
        return $this->permission;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function getCssClass(): ?string
    {
        return $this->cssClass;
    }

    public function getTranslationParams(): array
    {
        return $this->translationParams ?? [];
    }

    public function getConfiguredTemplateName(): ?string
    {
        return $this->templateName;
    }

    public function getConfiguredTemplatePath(): ?string
    {
        return $this->templatePath;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function getCssFiles(): array
    {
        return $this->cssFiles ?? [];
    }

    public function getJsFiles(): array
    {
        return $this->jsFiles ?? [];
    }

    public function getHeadContents(): array
    {
        return $this->headContents ?? [];
    }

    public function getBodyContents(): array
    {
        return $this->bodyContents ?? [];
    }

    public function getCustomOptions(): ParameterBag
    {
        if (null !== $customOptions = $this->processedCustomOptions) {
            return $customOptions;
        }

        return $this->processedCustomOptions = new ParameterBag($this->customOptions ?? []);
    }

    public function getCustomOption(string $optionName)
    {
        return $this->getCustomOptions()->get($optionName);
    }

    public function getAsDto(): PropertyDto
    {
        return new PropertyDto($this->type, $this->name, $this->value, $this->formattedValue, $this->formType, $this->formTypeOptions ?? [], $this->sortable, $this->virtual, $this->label, $this->permission, $this->textAlign ?? 'left', $this->help, $this->cssClass, $this->translationParams ?? [], $this->templateName, $this->templatePath, new AssetDto($this->getCssFiles(), $this->getJsFiles(), $this->getHeadContents(), $this->getBodyContents()), $this->getCustomOptions());
    }

    public function setName(string $name): PropertyConfigInterface
    {
        $this->name = $name;

        return $this;
    }

    public function setLabel(string $label): PropertyConfigInterface
    {
        $this->label = $label;

        return $this;
    }

    public function setValue($value): PropertyConfigInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setFormattedValue($value): PropertyConfigInterface
    {
        $this->formattedValue = $value;

        return $this;
    }

    public function setVirtual(bool $isVirtual): PropertyConfigInterface
    {
        $this->virtual = $isVirtual;

        return $this;
    }

    public function setType(string $type): PropertyConfigInterface
    {
        $this->type = str_replace(' ', '-', $type);

        return $this;
    }

    public function setFormType(string $formType): PropertyConfigInterface
    {
        $this->formType = $formType;

        return $this;
    }

    public function setFormTypeOptions(array $options): PropertyConfigInterface
    {
        $this->formTypeOptions = $options;

        return $this;
    }

    public function setSortable(bool $isSortable): PropertyConfigInterface
    {
        $this->sortable = $isSortable;

        return $this;
    }

    public function setPermission(string $role): PropertyConfigInterface
    {
        $this->permission = $role;

        return $this;
    }

    public function setTextAlign(string $textAlign): PropertyConfigInterface
    {
        $validOptions = ['left', 'center', 'right'];
        if (!\in_array($textAlign, $validOptions)) {
            throw new \InvalidArgumentException(sprintf('The value of the "textAlign" option can only be one of these: "%s" ("%s" was given).', implode(',', $validOptions), $textAlign));
        }

        $this->textAlign = $textAlign;

        return $this;
    }

    public function setHelp(string $help): PropertyConfigInterface
    {
        $this->help = $help;

        return $this;
    }

    public function setCssClass(string $cssClass): PropertyConfigInterface
    {
        $this->cssClass = $cssClass;

        return $this;
    }

    public function setTranslationParams(array $params): PropertyConfigInterface
    {
        $this->translationParams = $params;

        return $this;
    }

    public function setTemplatePath(string $path): PropertyConfigInterface
    {
        $this->templatePath = $path;
        $this->templateName = null;

        return $this;
    }

    public function setTemplateName(string $name): PropertyConfigInterface
    {
        $this->templateName = $name;
        $this->templatePath = null;

        return $this;
    }

    public function addCssFiles(string ...$assetPaths): PropertyConfigInterface
    {
        $this->cssFiles = array_merge($this->cssFiles, $assetPaths);

        return $this;
    }

    public function addJsFiles(string ...$assetPaths): PropertyConfigInterface
    {
        $this->jsFiles = array_merge($this->jsFiles, $assetPaths);

        return $this;
    }

    public function addHtmlContentsToHead(string ...$contents): PropertyConfigInterface
    {
        $this->headContents = array_merge($this->headContents, $contents);

        return $this;
    }

    public function addHtmlContentsToBody(string ...$contents): PropertyConfigInterface
    {
        $this->bodyContents = array_merge($this->bodyContents, $contents);

        return $this;
    }

    public function setCustomOption(string $optionName, $optionValue): PropertyConfigInterface
    {
        $this->customOptions[$optionName] = $optionValue;
        $this->processedCustomOptions = null;

        return $this;
    }

    public function setCustomOptions(array $options): PropertyConfigInterface
    {
        foreach ($options as $optionName => $optionValue) {
            $this->setCustomOption($optionName, $optionValue);
        }

        return $this;
    }
}