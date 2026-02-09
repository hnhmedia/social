<?php
/**
 * Mega Menu Integration
 * Gets categories and services for navigation menu
 */

require_once __DIR__ . '/dynamic_service_integration.php';

/**
 * Get mega menu structure for Services dropdown
 * Returns categories with their services
 * 
 * @return array Menu structure
 */
function getMegaMenuServices() { 

        $hierarchy = getAllServicesHierarchy();

       //  print_r($hierarchy);echo "@34";exit;
        
        // Format for menu display
        $menuData = [];
        foreach ($hierarchy as $category) {
            $menuData[] = [
                'category' => [
                    'name' => $category['name'],
                    'slug' => $category['slug'],
                    'icon' => $category['icon']
                ],
                'services' => $category['services']
            ];
        }
        
        return $menuData;
        

}

/**
 * Generate mega menu HTML
 * 
 * @return string HTML for mega menu
 */
function generateMegaMenuHTML() { 
    $menuData = getMegaMenuServices();
    
    ob_start();
    ?>
    <div class="mega-menu-dropdown">
        <div class="mega-menu-inner">
            <?php foreach($menuData as $item): ?>
            <div class="mega-menu-column">
                <div class="mega-menu-category">
                    <?php if ($item['category']['icon']): ?>
                    <span class="category-icon"><?php echo $item['category']['icon']; ?></span>
                    <?php endif; ?>
                    <span class="category-name"><?php echo htmlspecialchars($item['category']['name']); ?> Services</span>
                </div>
                <ul class="mega-menu-list">
                    <?php foreach($item['services'] as $service): ?>
                    <li>
                        <a href="/sgi/<?php echo htmlspecialchars($service['slug']); ?>">
                            <?php if (!empty($service['icon'])): ?>
                            <span class="service-icon"><?php echo $service['icon']; ?></span>
                            <?php endif; ?>
                            <span><?php echo htmlspecialchars($service['name']); ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
