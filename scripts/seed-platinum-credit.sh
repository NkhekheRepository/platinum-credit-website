#!/bin/bash
# Seed 9 Platinum Credit pages + menus via WP-CLI

WPCLI="docker exec -u www-data pcl-wordpress php /opt/tools/wp-cli.phar"

echo "=== Seeding Platinum Credit pages ==="

# Home page (set as front page)
HOME_ID=$($WPCLI post create --post_type=page --post_title='Home' --post_status=publish --post_name='home' --porcelain 2>/dev/null)
echo "Home: $HOME_ID"

# About
ABOUT_ID=$($WPCLI post create --post_type=page --post_title='About' --post_status=publish --post_name='about' --porcelain 2>/dev/null)
echo "About: $ABOUT_ID"

# Products (single page with 6-card grid)
PRODUCTS_ID=$($WPCLI post create --post_type=page --post_title='Products' --post_status=publish --post_name='products' --porcelain 2>/dev/null)
echo "Products: $PRODUCTS_ID"

# How It Works
HOW_ID=$($WPCLI post create --post_type=page --post_title='How It Works' --post_status=publish --post_name='how-it-works' --porcelain 2>/dev/null)
echo "How It Works: $HOW_ID"

# Estimator
EST_ID=$($WPCLI post create --post_type=page --post_title='Estimator' --post_status=publish --post_name='estimator' --porcelain 2>/dev/null)
echo "Estimator: $EST_ID"

# Affordability
AFF_ID=$($WPCLI post create --post_type=page --post_title='Affordability' --post_status=publish --post_name='affordability' --porcelain 2>/dev/null)
echo "Affordability: $AFF_ID"

# Contact
CONTACT_ID=$($WPCLI post create --post_type=page --post_title='Contact' --post_status=publish --post_name='contact' --porcelain 2>/dev/null)
echo "Contact: $CONTACT_ID"

# Privacy
PRIV_ID=$($WPCLI post create --post_type=page --post_title='Privacy Policy' --post_status=publish --post_name='privacy-policy' --porcelain 2>/dev/null)
echo "Privacy: $PRIV_ID"

# Legal/Disclosures
LEGAL_ID=$($WPCLI post create --post_type=page --post_title='Legal Disclosures' --post_status=publish --post_name='legal-disclosures' --porcelain 2>/dev/null)
echo "Legal: $LEGAL_ID"

# Set Home as front page
$WPCLI option update show_on_front 'page' 2>/dev/null
$WPCLI option update page_on_front $HOME_ID 2>/dev/null
echo "Front page set to Home ($HOME_ID)"

# Remove default Hello World post
$WPCLI post delete 1 --force 2>/dev/null

# Set up Primary Menu
echo "=== Setting up menus ==="
$WPCLI menu create "Primary" 2>/dev/null
$WPCLI menu item add-custom Primary "Home" "#top" --menu-item-class=pcl-cta 2>/dev/null
$WPCLI menu item add-post-type Primary $ABOUT_ID --title="Who We Are" 2>/dev/null
$WPCLI menu item add-post-type Primary $PRODUCTS_ID --title="Products" 2>/dev/null
$WPCLI menu item add-post-type Primary $HOW_ID --title="How It Works" 2>/dev/null
$WPCLI menu item add-post-type Primary $EST_ID --title="Estimator" 2>/dev/null
$WPCLI menu item add-post-type Primary $CONTACT_ID --title="Contact" 2>/dev/null
$WPCLI menu item add-custom Primary "Apply Now" "#contact" --menu-item-class=pcl-cta 2>/dev/null
$WPCLI menu location assign Primary primary 2>/dev/null
echo "Primary menu created and assigned"

# Set up Footer Menu
$WPCLI menu create "Footer" 2>/dev/null
$WPCLI menu item add-post-type Footer $ABOUT_ID --title="About" 2>/dev/null
$WPCLI menu item add-post-type Footer $PRODUCTS_ID --title="Products" 2>/dev/null
$WPCLI menu item add-post-type Footer $HOW_ID --title="Process" 2>/dev/null
$WPCLI menu item add-post-type Footer $EST_ID --title="Estimator" 2>/dev/null
$WPCLI menu item add-post-type Footer $AFF_ID --title="Affordability" 2>/dev/null
$WPCLI menu item add-post-type Footer $CONTACT_ID --title="Contact" 2>/dev/null
$WPCLI menu location assign Footer footer 2>/dev/null
echo "Footer menu created and assigned"

echo "=== Done! ==="
echo "Pages: Home=$HOME_ID About=$ABOUT_ID Products=$PRODUCTS_ID How=$HOW_ID Estimator=$EST_ID Affordability=$AFF_ID Contact=$CONTACT_ID Privacy=$PRIV_ID Legal=$LEGAL_ID"
