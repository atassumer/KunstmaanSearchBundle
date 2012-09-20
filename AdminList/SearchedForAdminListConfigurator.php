<?php
namespace Kunstmaan\SearchBundle\AdminList;

use Kunstmaan\AdminListBundle\AdminList\AdminListFilter;
use Doctrine\ORM\PersistentCollection;
use Kunstmaan\ViewBundle\Entity\SearchPage;
use Kunstmaan\AdminListBundle\AdminList\Filters\DateFilter;
use Kunstmaan\AdminListBundle\AdminList\Filters\StringFilter;
use Kunstmaan\AdminListBundle\AdminList\AbstractAdminListConfigurator;

/**
 * TODO: Fill out the docbook comments
 */
class SearchedForAdminListConfigurator extends AbstractAdminListConfigurator
{

    /**
     * @param \Kunstmaan\AdminListBundle\AdminList\AdminListFilter $builder
     */
    public function buildFilters(AdminListFilter $builder)
    {
        $builder->add('query', new StringFilter("query"), "Query");
        $builder->add('createdat', new DateFilter('createdat'), "Created At");
    }

    /**
     * Configure the visible columns
     */
    public function buildFields()
    {
        $this->addField("query", "Query", true);
        $this->addField("searchpage", "Search Page", false);
        $this->addField("createdat", "Created At", false);
    }

    /**
     * @return bool
     */
    public function canAdd()
    {
        return false;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getAddUrlFor(array $params = array())
    {
        return array();
    }

    /**
     * @param mixed $item
     *
     * @return bool
     */
    public function canEdit($item)
    {
        return false;
    }

    /**
     * @param mixed $item
     *
     * @return array
     */
    public function getEditUrlFor($item)
    {
        return array();
    }

    /**
     * @return array
     */
    public function getIndexUrlFor()
    {
        return array('path' => 'KunstmaanAdminBundle_settings_searches');
    }

    /**
     * @param mixed $item
     *
     * @return bool
     */
    public function canDelete($item)
    {
        return false;
    }

    /**
     * @param mixed $item
     *
     * @return null
     */
    public function getAdminType($item)
    {
        return null;
    }

    /**
     * @return string
     */
    public function getRepositoryName()
    {
        return 'KunstmaanSearchBundle:SearchedFor';
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $querybuilder The query builder
     * @param array                      $params       Extra parameters
     */
    public function adaptQueryBuilder(\Doctrine\ORM\QueryBuilder $querybuilder, array $params = array())
    {
        parent::adaptQueryBuilder($querybuilder);
        //not needed to change something here yet but already
    }

    /**
     * @param mixed  $item       The item
     * @param string $columnName The column name
     *
     * @return string
     */
    public function getValue($item, $columnName)
    {
        $result = parent::getValue($item, $columnName);
        if ($result instanceof SearchPage) {
            /** @var SearchPage $result */
            $parent = $result->getParent();
            /** @var HasNodeInterface $parent */
            if ($parent) {
                return $parent->getTitle() . "/" . $result->getTitle();
            } else {
                return "/" . $result->getTitle();
            }
        }
        if ($result instanceof PersistentCollection) {
            $results = "";
            foreach ($result as $entry) {
                $results[] = $entry->getName();
            }
            if (empty($results)) {
                return "";
            }

            return implode(', ', $results);
        }

        return $result;
    }

    /**
     * @param mixed $item
     */
    public function getDeleteUrlFor($item)
    {
        // TODO: Implement getDeleteUrlFor() method.
    }
}
