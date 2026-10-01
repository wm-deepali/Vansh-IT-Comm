/**
 * VANSH IT & COMM — CORE DATA STORE
 * Realistic demo data for products, categories, brands, FAQs, reviews, and blog articles.
 */

const PRODUCTS_DATA = [
  // ==========================================
  // LAPTOPS (10 Items)
  // ==========================================
  {
    id: 'lap-01',
    name: 'Dell Latitude 5420 Business Laptop',
    category: 'laptops',
    subcategory: 'business',
    brand: 'Dell',
    condition: 'Refurbished',
    price: 32499,
    mrp: 89999,
    discount: 64,
    rating: 4.8,
    reviewsCount: 142,
    image: 'img/product-1593642632823-8f785ba67e45.jpg',
    gallery: [
      'img/product-1593642632823-8f785ba67e45.jpg',
      'img/product-1588872657578-7efd1f1555ed.jpg',
      'img/product-1541807084-5c52b6b3adef.jpg'
    ],
    processor: 'Intel Core i5 11th Gen (1145G7)',
    ram: '16 GB DDR4',
    storage: '512 GB NVMe SSD',
    display: '14" Full HD Anti-Glare (1920x1080)',
    graphics: 'Intel Iris Xe Graphics',
    screenSize: '14 inch',
    os: 'Windows 11 Pro Genuine',
    batteryHealth: '88% (4-6 Hrs Backup)',
    warranty: '12 Month Warranty',
    badge: 'REFURBISHED',
    featured: true,
    under15k: false,
    under25k: false,
    under35k: true,
    description: 'Enterprise-grade Dell Latitude 5420 meticulously tested across 20 quality points. Features durable carbon fiber chassis, thunderbolt ports, backlit keyboard, and pristine battery performance for professional productivity.'
  },
  {
    id: 'lap-02',
    name: 'Lenovo ThinkPad T480 Ultrabook',
    category: 'laptops',
    subcategory: 'coding',
    brand: 'Lenovo',
    condition: 'Refurbished',
    price: 21999,
    mrp: 74999,
    discount: 71,
    rating: 4.7,
    reviewsCount: 218,
    image: 'img/product-1588872657578-7efd1f1555ed.jpg',
    gallery: [
      'img/product-1588872657578-7efd1f1555ed.jpg',
      'img/product-1541807084-5c52b6b3adef.jpg'
    ],
    processor: 'Intel Core i5 8th Gen Quad-Core',
    ram: '16 GB DDR4',
    storage: '256 GB SSD',
    display: '14" Full HD IPS Display',
    graphics: 'Intel UHD Graphics 620',
    screenSize: '14 inch',
    os: 'Windows 11 Pro',
    batteryHealth: '85% Dual Battery System',
    warranty: '12 Month Warranty',
    badge: 'BEST SELLER',
    featured: true,
    under15k: false,
    under25k: true,
    under35k: true,
    description: 'The legendary developer favorite ThinkPad T480 with world-class ergonomic keyboard, legendary dual bridge battery, robust military-spec durability, and seamless Linux/Windows dual boot readiness.'
  },
  {
    id: 'lap-03',
    name: 'Apple MacBook Air M1 (2020)',
    category: 'laptops',
    subcategory: 'students',
    brand: 'Apple',
    condition: 'Refurbished',
    price: 54999,
    mrp: 99900,
    discount: 45,
    rating: 4.9,
    reviewsCount: 310,
    image: 'img/product-1611186871348-b1ce696e52c9.jpg',
    gallery: [
      'img/product-1611186871348-b1ce696e52c9.jpg',
      'img/product-1517336714731-489689fd1ca8.jpg'
    ],
    processor: 'Apple Silicon M1 (8-core CPU)',
    ram: '8 GB Unified Memory',
    storage: '256 GB PCIe SSD',
    display: '13.3" Retina Display with True Tone',
    graphics: '7-core GPU',
    screenSize: '13.3 inch',
    os: 'macOS Sonoma Updated',
    batteryHealth: '92% Battery Health (12+ Hrs)',
    warranty: '12 Month Warranty',
    badge: 'HOT DEAL',
    featured: true,
    under15k: false,
    under25k: false,
    under35k: false,
    description: 'Iconic silent fanless performance with lightning fast Apple M1 chip. Immaculate body condition, pristine Retina screen, 100% genuine original charger included.'
  },
  {
    id: 'lap-04',
    name: 'HP EliteBook 840 G6 Ultrabook',
    category: 'laptops',
    subcategory: 'business',
    brand: 'HP',
    condition: 'Refurbished',
    price: 24999,
    mrp: 82000,
    discount: 70,
    rating: 4.6,
    reviewsCount: 95,
    image: 'img/product-1544716278-ca5e3f4abd8c.jpg',
    gallery: [
      'img/product-1544716278-ca5e3f4abd8c.jpg'
    ],
    processor: 'Intel Core i5 8th Gen (8365U)',
    ram: '16 GB DDR4',
    storage: '512 GB NVMe SSD',
    display: '14" Full HD Slim IPS',
    graphics: 'Intel UHD 620',
    screenSize: '14 inch',
    os: 'Windows 11 Pro',
    batteryHealth: '87% Health',
    warranty: '12 Month Warranty',
    badge: 'REFURBISHED',
    featured: false,
    under15k: false,
    under25k: true,
    under35k: true,
    description: 'Sleek silver all-metal CNC aluminum design with Bang & Olufsen tuned quad speakers, privacy shutter webcam, and ultra-fast NVMe storage for corporate power users.'
  },
  {
    id: 'lap-05',
    name: 'Lenovo IdeaPad 3 Slim Student Laptop',
    category: 'laptops',
    subcategory: 'students',
    brand: 'Lenovo',
    condition: 'Refurbished',
    price: 14499,
    mrp: 38990,
    discount: 63,
    rating: 4.5,
    reviewsCount: 78,
    image: 'img/product-1496181133206-80ce9b88a853.jpg',
    gallery: [
      'img/product-1496181133206-80ce9b88a853.jpg'
    ],
    processor: 'AMD Ryzen 3 3250U Dual Core',
    ram: '8 GB DDR4',
    storage: '256 GB SSD',
    display: '15.6" HD Anti-Glare',
    graphics: 'AMD Radeon Vega 3',
    screenSize: '15.6 inch',
    os: 'Windows 10 Home (Upgradable)',
    batteryHealth: '89% Health',
    warranty: '6 Month Warranty',
    badge: 'UNDER 15K',
    featured: false,
    under15k: true,
    under25k: true,
    under35k: true,
    description: 'Perfect high-value laptop for online classes, school projects, office spreadsheets, and video streaming with full numeric keypad and fast SSD boot times.'
  },
  {
    id: 'lap-06',
    name: 'Asus TUF Gaming F15',
    category: 'laptops',
    subcategory: 'gaming',
    brand: 'Asus',
    condition: 'Open Box',
    price: 48999,
    mrp: 75990,
    discount: 36,
    rating: 4.8,
    reviewsCount: 64,
    image: 'img/product-1603302576837-37561b2e2302.jpg',
    gallery: [
      'img/product-1603302576837-37561b2e2302.jpg'
    ],
    processor: 'Intel Core i5 11th Gen 11400H',
    ram: '16 GB DDR4 3200MHz',
    storage: '512 GB PCIe 4.0 SSD',
    display: '15.6" FHD 144Hz IPS Level',
    graphics: 'NVIDIA GeForce RTX 3050 4GB',
    screenSize: '15.6 inch',
    os: 'Windows 11 Home',
    batteryHealth: '100% (Open Box Unused)',
    warranty: '12 Month Warranty',
    badge: 'OPEN BOX',
    featured: true,
    under15k: false,
    under25k: false,
    under35k: false,
    description: 'High-performance gaming machine ready for AAA gaming, 3D rendering, video editing, and simulations with dual self-cleaning fans and RGB keyboard.'
  },
  {
    id: 'lap-07',
    name: 'Dell Precision 3530 Workstation',
    category: 'laptops',
    subcategory: 'design',
    brand: 'Dell',
    condition: 'Refurbished',
    price: 34999,
    mrp: 115000,
    discount: 70,
    rating: 4.7,
    reviewsCount: 52,
    image: 'img/product-1541807084-5c52b6b3adef.jpg',
    gallery: [
      'img/product-1541807084-5c52b6b3adef.jpg'
    ],
    processor: 'Intel Core i7 8th Gen 6-Core',
    ram: '32 GB DDR4 High Speed',
    storage: '512 GB SSD + 1TB HDD',
    display: '15.6" FHD PremierColor IPS',
    graphics: 'NVIDIA Quadro P600 4GB Dedicated',
    screenSize: '15.6 inch',
    os: 'Windows 11 Pro',
    batteryHealth: '86% Health',
    warranty: '12 Month Warranty',
    badge: 'WORKSTATION',
    featured: false,
    under15k: false,
    under25k: false,
    under35k: true,
    description: 'Certified ISV mobile workstation built for AutoCAD, SolidWorks, Revit, Adobe Premiere, and heavy multitasking with immense 32GB RAM.'
  },
  {
    id: 'lap-08',
    name: 'Acer Aspire 5 Slim Notebook',
    category: 'laptops',
    subcategory: 'normal',
    brand: 'Acer',
    condition: 'Refurbished',
    price: 18999,
    mrp: 46990,
    discount: 60,
    rating: 4.4,
    reviewsCount: 88,
    image: 'img/product-1525547719571-a2d4ac8945e2.jpg',
    gallery: [
      'img/product-1525547719571-a2d4ac8945e2.jpg'
    ],
    processor: 'Intel Core i3 10th Gen',
    ram: '8 GB DDR4',
    storage: '256 GB NVMe SSD',
    display: '15.6" Full HD Narrow Bezel',
    graphics: 'Intel UHD Graphics',
    screenSize: '15.6 inch',
    os: 'Windows 11 Home',
    batteryHealth: '90% Health',
    warranty: '6 Month Warranty',
    badge: 'UNDER 25K',
    featured: false,
    under15k: false,
    under25k: true,
    under35k: true,
    description: 'Crisp 1080p screen, lightweight body, and super fast boot times makes this Acer Aspire 5 a dependable daily driver for home and remote work.'
  },
  {
    id: 'lap-09',
    name: 'Apple MacBook Pro 16" TouchBar',
    category: 'laptops',
    subcategory: 'design',
    brand: 'Apple',
    condition: 'Refurbished',
    price: 68999,
    mrp: 199900,
    discount: 65,
    rating: 4.9,
    reviewsCount: 114,
    image: 'img/product-1517336714731-489689fd1ca8.jpg',
    gallery: [
      'img/product-1517336714731-489689fd1ca8.jpg'
    ],
    processor: 'Intel Core i7 9th Gen 6-Core 2.6GHz',
    ram: '16 GB 2666MHz DDR4',
    storage: '512 GB SSD',
    display: '16" Retina Display (3072x1920)',
    graphics: 'AMD Radeon Pro 5300M 4GB',
    screenSize: '16 inch',
    os: 'macOS Sonoma',
    batteryHealth: '89% (Original cycle count verified)',
    warranty: '12 Month Warranty',
    badge: 'FLAGSHIP',
    featured: true,
    under15k: false,
    under25k: false,
    under35k: false,
    description: 'Monumental 6-speaker sound system with studio quality mics, expansive 16-inch high-density Retina screen, and dedicated Radeon Pro graphics for audio/video creators.'
  },
  {
    id: 'lap-10',
    name: 'Dell Inspiron 3501 Core i3',
    category: 'laptops',
    subcategory: 'students',
    brand: 'Dell',
    condition: 'Refurbished',
    price: 14999,
    mrp: 41000,
    discount: 63,
    rating: 4.5,
    reviewsCount: 66,
    image: 'img/product-1588872657578-7efd1f1555ed.jpg',
    gallery: [
      'img/product-1588872657578-7efd1f1555ed.jpg'
    ],
    processor: 'Intel Core i3 10th Gen',
    ram: '8 GB DDR4',
    storage: '128 GB SSD + 1TB HDD',
    display: '15.6" Anti-Glare LED Display',
    graphics: 'Intel UHD Graphics',
    screenSize: '15.6 inch',
    os: 'Windows 10 Pro',
    batteryHealth: '86% Health',
    warranty: '6 Month Warranty',
    badge: 'UNDER 15K',
    featured: false,
    under15k: true,
    under25k: true,
    under35k: true,
    description: 'Massive dual storage combination with snappy SSD speed for OS plus 1TB space for photos, movies and study materials. Fully tested with zero faults.'
  },

  // ==========================================
  // MOBILE PHONES (10 Items)
  // ==========================================
  {
    id: 'mob-01',
    name: 'Apple iPhone 13 (128 GB)',
    category: 'mobile-phones',
    subcategory: 'premium',
    brand: 'Apple',
    condition: 'Refurbished',
    price: 38999,
    mrp: 59900,
    discount: 35,
    rating: 4.8,
    reviewsCount: 420,
    image: 'img/product-1511707171634-5f897ff02aa9.jpg',
    gallery: [
      'img/product-1511707171634-5f897ff02aa9.jpg',
      'img/product-1592750475338-74b7b21085ab.jpg'
    ],
    processor: 'A15 Bionic Chip (5nm)',
    ram: '4 GB RAM',
    storage: '128 GB Internal',
    display: '6.1" Super Retina XDR OLED',
    camera: '12MP + 12MP Cinematic Mode 4K',
    batteryHealth: '89% Battery Health (Verified)',
    os: 'iOS 17 Compatible',
    warranty: '12 Month Warranty',
    badge: 'HOT DEAL',
    featured: true,
    under10k: false,
    under15k: false,
    under25k: false,
    description: 'Flawless cosmetic condition iPhone 13. Features sensor-shift optical image stabilization, ceramic shield front glass, 5G connectivity and all original OEM hardware.'
  },
  {
    id: 'mob-02',
    name: 'Samsung Galaxy S22 5G (8GB / 128GB)',
    category: 'mobile-phones',
    subcategory: 'premium',
    brand: 'Samsung',
    condition: 'Refurbished',
    price: 28999,
    mrp: 72999,
    discount: 60,
    rating: 4.7,
    reviewsCount: 180,
    image: 'img/product-1610945265064-0e34e5519bbf.jpg',
    gallery: [
      'img/product-1610945265064-0e34e5519bbf.jpg'
    ],
    processor: 'Snapdragon 8 Gen 1 (4nm)',
    ram: '8 GB LPDDR5',
    storage: '128 GB UFS 3.1',
    display: '6.1" Dynamic AMOLED 2X 120Hz',
    camera: '50MP + 10MP (3x Zoom) + 12MP Ultra Wide',
    batteryHealth: '91% Battery Health',
    os: 'One UI 6 (Android 14)',
    warranty: '12 Month Warranty',
    badge: 'REFURBISHED',
    featured: true,
    under10k: false,
    under15k: false,
    under25k: false,
    description: 'Compact premium flagship with nightography camera sensor, Armor Aluminum frame, 120Hz silky smooth AMOLED display, and full IP68 water resistance.'
  },
  {
    id: 'mob-03',
    name: 'OnePlus 11R 5G (8GB / 128GB)',
    category: 'mobile-phones',
    subcategory: 'gaming',
    brand: 'OnePlus',
    condition: 'Open Box',
    price: 24999,
    mrp: 39999,
    discount: 38,
    rating: 4.8,
    reviewsCount: 165,
    image: 'img/product-1565849904461-04a58ad377e0.jpg',
    gallery: [
      'img/product-1565849904461-04a58ad377e0.jpg'
    ],
    processor: 'Snapdragon 8+ Gen 1 Flagship',
    ram: '8 GB LPDDR5X',
    storage: '128 GB',
    display: '6.74" Super Fluid AMOLED 120Hz',
    camera: '50MP Sony IMX890 OIS',
    batteryHealth: '100% (100W SUPERVOOC Charger Included)',
    os: 'OxygenOS 14 (Android 14)',
    warranty: '12 Month Warranty',
    badge: 'UNDER 25K',
    featured: true,
    under10k: false,
    under15k: false,
    under25k: true,
    description: 'Unmatched gaming performance with 100W blazing fast charging (0 to 100% in 25 mins), flagship IMX890 camera sensor and alert slider.'
  },
  {
    id: 'mob-04',
    name: 'Google Pixel 7 5G (8GB / 128GB)',
    category: 'mobile-phones',
    subcategory: 'photography',
    brand: 'Google Pixel',
    condition: 'Refurbished',
    price: 26999,
    mrp: 59999,
    discount: 55,
    rating: 4.9,
    reviewsCount: 210,
    image: 'img/product-1598327105666-5b89351aff97.jpg',
    gallery: [
      'img/product-1598327105666-5b89351aff97.jpg'
    ],
    processor: 'Google Tensor G2 with Titan M2',
    ram: '8 GB LPDDR5',
    storage: '128 GB UFS 3.1',
    display: '6.3" FHD+ OLED 90Hz HDR10+',
    camera: '50MP Octa PD Quad Bayer + 12MP Ultra-wide',
    batteryHealth: '92% Battery Health',
    os: 'Clean Stock Android 14',
    warranty: '12 Month Warranty',
    badge: 'CAMERA KING',
    featured: true,
    under10k: false,
    under15k: false,
    under25k: false,
    description: 'The ultimate computational photography phone with Magic Eraser, Real Tone skin tone accuracy, photo unblur, and guaranteed direct Android updates.'
  },
  {
    id: 'mob-05',
    name: 'Xiaomi Redmi Note 12 Pro 5G',
    category: 'mobile-phones',
    subcategory: 'everyday',
    brand: 'Xiaomi',
    condition: 'Refurbished',
    price: 13999,
    mrp: 27999,
    discount: 50,
    rating: 4.6,
    reviewsCount: 130,
    image: 'img/product-1574944985070-8f3ebc6b79d2.jpg',
    gallery: [
      'img/product-1574944985070-8f3ebc6b79d2.jpg'
    ],
    processor: 'MediaTek Dimensity 1080 5G',
    ram: '6 GB LPDDR4X',
    storage: '128 GB UFS 2.2',
    display: '6.67" Pro AMOLED 120Hz Dolby Vision',
    camera: '50MP Sony IMX766 OIS Camera',
    batteryHealth: '90% (5000mAh Battery)',
    os: 'MIUI 14 with Android 13',
    warranty: '6 Month Warranty',
    badge: 'UNDER 15K',
    featured: false,
    under10k: false,
    under15k: true,
    under25k: true,
    description: 'Outstanding mid-range performer featuring flagship Sony IMX766 sensor with OIS, 67W turbo charging, and stunning 120Hz Dolby Vision AMOLED screen.'
  },
  {
    id: 'mob-06',
    name: 'Realme Narzo 50A Prime',
    category: 'mobile-phones',
    subcategory: 'students',
    brand: 'Realme',
    condition: 'Refurbished',
    price: 6999,
    mrp: 14499,
    discount: 52,
    rating: 4.3,
    reviewsCount: 89,
    image: 'img/product-1580910051074-3eb694886505.jpg',
    gallery: [
      'img/product-1580910051074-3eb694886505.jpg'
    ],
    processor: 'Unisoc T612 Octa-core',
    ram: '4 GB RAM',
    storage: '64 GB (Expandable up to 1TB)',
    display: '6.6" FHD+ Fullscreen Display',
    camera: '50MP AI Triple Camera',
    batteryHealth: '94% (5000mAh Massive Battery)',
    os: 'Realme UI R Edition',
    warranty: '6 Month Warranty',
    badge: 'UNDER 10K',
    featured: false,
    under10k: true,
    under15k: true,
    under25k: true,
    description: 'Ultra-affordable reliable phone with crisp 1080p high-resolution screen, massive all-day 5000mAh battery, and sharp 50MP AI primary camera.'
  },
  {
    id: 'mob-07',
    name: 'Motorola Moto G73 5G',
    category: 'mobile-phones',
    subcategory: 'everyday',
    brand: 'Motorola',
    condition: 'Refurbished',
    price: 11499,
    mrp: 21999,
    discount: 48,
    rating: 4.5,
    reviewsCount: 75,
    image: 'img/product-1598327105666-5b89351aff97.jpg',
    gallery: [
      'img/product-1598327105666-5b89351aff97.jpg'
    ],
    processor: 'MediaTek Dimensity 930 5G',
    ram: '8 GB RAM',
    storage: '128 GB',
    display: '6.5" FHD+ 120Hz Ultra Smooth',
    camera: '50MP 2.0um Ultra Pixel + 8MP Macro/Wide',
    batteryHealth: '91% (5000mAh Battery)',
    os: 'Clean MyUX Android 13',
    warranty: '6 Month Warranty',
    badge: 'UNDER 15K',
    featured: false,
    under10k: false,
    under15k: true,
    under25k: true,
    description: 'Ad-free clean stock Android experience with 13 5G bands support, stereo speakers with Dolby Atmos, and massive 8GB RAM for zero stutter multitasking.'
  },
  {
    id: 'mob-08',
    name: 'Apple iPhone 11 (64 GB)',
    category: 'mobile-phones',
    subcategory: 'premium',
    brand: 'Apple',
    condition: 'Refurbished',
    price: 21499,
    mrp: 49900,
    discount: 57,
    rating: 4.7,
    reviewsCount: 380,
    image: 'img/product-1592750475338-74b7b21085ab.jpg',
    gallery: [
      'img/product-1592750475338-74b7b21085ab.jpg'
    ],
    processor: 'A13 Bionic 3rd Gen Neural Engine',
    ram: '4 GB RAM',
    storage: '64 GB',
    display: '6.1" Liquid Retina HD Display',
    camera: '12MP Ultra-Wide and Wide with Night Mode',
    batteryHealth: '87% Original Battery Health',
    os: 'iOS 17 Compatible',
    warranty: '12 Month Warranty',
    badge: 'BEST SELLER',
    featured: false,
    under10k: false,
    under15k: false,
    under25k: true,
    description: 'The most popular entry point into the Apple ecosystem. Durable glass design, water resistance, 4K 60fps video recording on all lenses, and all-day battery.'
  },
  {
    id: 'mob-09',
    name: 'Samsung Galaxy M34 5G (6GB / 128GB)',
    category: 'mobile-phones',
    subcategory: 'everyday',
    brand: 'Samsung',
    condition: 'Refurbished',
    price: 12499,
    mrp: 24499,
    discount: 49,
    rating: 4.6,
    reviewsCount: 110,
    image: 'img/product-1610945265064-0e34e5519bbf.jpg',
    gallery: [
      'img/product-1610945265064-0e34e5519bbf.jpg'
    ],
    processor: 'Exynos 1280 5nm Octa-Core',
    ram: '6 GB RAM',
    storage: '128 GB',
    display: '6.5" Super AMOLED 120Hz Gorilla Glass 5',
    camera: '50MP No Shake OIS Camera',
    batteryHealth: '93% (Monster 6000mAh Battery)',
    os: 'One UI 6 Android 14',
    warranty: '6 Month Warranty',
    badge: 'UNDER 15K',
    featured: false,
    under10k: false,
    under15k: true,
    under25k: true,
    description: 'Monster 6000mAh battery that easily lasts 2 full days on single charge, paired with vibrant 120Hz Super AMOLED display and OIS camera.'
  },
  {
    id: 'mob-10',
    name: 'Vivo T2x 5G (6GB / 128GB)',
    category: 'mobile-phones',
    subcategory: 'students',
    brand: 'Vivo',
    condition: 'Refurbished',
    price: 9999,
    mrp: 18999,
    discount: 47,
    rating: 4.4,
    reviewsCount: 94,
    image: 'img/product-1565849904461-04a58ad377e0.jpg',
    gallery: [
      'img/product-1565849904461-04a58ad377e0.jpg'
    ],
    processor: 'MediaTek Dimensity 6020 7nm 5G',
    ram: '6 GB (+6GB Extended RAM)',
    storage: '128 GB',
    display: '6.58" FHD+ Ultra Smooth Screen',
    camera: '50MP Super Night Camera',
    batteryHealth: '92% (5000mAh Battery)',
    os: 'Funtouch OS 13 Android 13',
    warranty: '6 Month Warranty',
    badge: 'UNDER 10K',
    featured: false,
    under10k: true,
    under15k: true,
    under25k: true,
    description: 'Top-tier 5G smartphone under ₹10,000 with 6GB physical RAM + 6GB virtual RAM expansion, slim matte finish body, and crystal clear night camera.'
  },

  // ==========================================
  // ACCESSORIES (10 Items)
  // ==========================================
  {
    id: 'acc-01',
    name: '65W GaN Fast Charger 3-Port (Type-C + USB-A)',
    category: 'accessories',
    subcategory: 'chargers',
    brand: 'VANSH Pro',
    condition: 'New',
    price: 1299,
    mrp: 2999,
    discount: 57,
    rating: 4.8,
    reviewsCount: 340,
    image: 'img/product-1583863788434-e58a36330cf0.jpg',
    gallery: [
      'img/product-1583863788434-e58a36330cf0.jpg'
    ],
    compatibility: 'MacBook, Dell, HP, ThinkPad, iPhone, Android',
    ports: '2x USB-C PD 3.0 + 1x USB-A QC 3.0',
    warranty: '12 Month Replacement Warranty',
    badge: 'BEST SELLER',
    featured: true,
    description: 'Compact Gallium Nitride (GaN) fast charger capable of charging your laptop and two smartphones simultaneously at full speed with built-in surge protection.'
  },
  {
    id: 'acc-02',
    name: 'Wireless Ergonomic Silent Optical Mouse',
    category: 'accessories',
    subcategory: 'peripherals',
    brand: 'Logitech',
    condition: 'New',
    price: 899,
    mrp: 1995,
    discount: 55,
    rating: 4.7,
    reviewsCount: 512,
    image: 'img/product-1527864550417-7fd91fc51a46.jpg',
    gallery: [
      'img/product-1527864550417-7fd91fc51a46.jpg'
    ],
    connectivity: '2.4GHz Wireless Nano Receiver + Bluetooth 5.0',
    batteryLife: 'Up to 18 Months on single AA',
    warranty: '12 Month Warranty',
    badge: 'NEW',
    featured: true,
    description: '90% noise reduced silent clicks with natural contoured grip designed to prevent wrist fatigue during long office or coding sessions.'
  },
  {
    id: 'acc-03',
    name: 'Aluminum Ergonomic Adjustable Laptop Stand',
    category: 'accessories',
    subcategory: 'stands',
    brand: 'VANSH Gear',
    condition: 'New',
    price: 799,
    mrp: 1999,
    discount: 60,
    rating: 4.9,
    reviewsCount: 290,
    image: 'img/product-1527443224154-c4a3942d3acf.jpg',
    gallery: [
      'img/product-1527443224154-c4a3942d3acf.jpg'
    ],
    material: 'Premium Sandblasted Aluminum Alloy',
    adjustability: '6-level height adjustment (10° to 45°)',
    warranty: '6 Month Warranty',
    badge: 'POPULAR',
    featured: true,
    description: 'Heavy duty foldable laptop stand providing optimal eye level posture and open hollow design for maximum airflow cooling.'
  },
  {
    id: 'acc-04',
    name: 'Crucial 500GB NVMe M.2 High-Speed SSD',
    category: 'accessories',
    subcategory: 'storage',
    brand: 'Crucial',
    condition: 'New',
    price: 2799,
    mrp: 4500,
    discount: 38,
    rating: 4.9,
    reviewsCount: 180,
    image: 'img/product-1597872200969-2b65d56bd16b.jpg',
    gallery: [
      'img/product-1597872200969-2b65d56bd16b.jpg'
    ],
    speed: 'Up to 3500 MB/s Read Speed (PCIe Gen3 x4)',
    formFactor: 'M.2 2280',
    warranty: '3 Year Manufacturer Warranty',
    badge: 'HIGH SPEED',
    featured: true,
    description: 'Instant upgrade for any slow laptop or PC. 6x faster than SATA SSDs, allowing sub-10 second boot times and instant game loading.'
  },
  {
    id: 'acc-05',
    name: '16GB DDR4 3200MHz Laptop RAM Module',
    category: 'accessories',
    subcategory: 'storage',
    brand: 'Samsung OEM',
    condition: 'New',
    price: 2499,
    mrp: 4999,
    discount: 50,
    rating: 4.8,
    reviewsCount: 145,
    image: 'img/product-1562976540-1502c2145186.jpg',
    gallery: [
      'img/product-1562976540-1502c2145186.jpg'
    ],
    speed: '3200 MT/s SO-DIMM 260-Pin',
    compatibility: 'Intel & AMD Laptops',
    warranty: '3 Year Warranty',
    badge: 'OEM ORIGINAL',
    featured: false,
    description: 'Double your memory to run Chrome with 50+ tabs, video editors, and IDEs smoothly without lag or throttling.'
  },
  {
    id: 'acc-06',
    name: 'Waterproof Anti-Theft Laptop Backpack (15.6")',
    category: 'accessories',
    subcategory: 'bags',
    brand: 'VANSH Gear',
    condition: 'New',
    price: 1199,
    mrp: 2999,
    discount: 60,
    rating: 4.7,
    reviewsCount: 220,
    image: 'img/product-1553062407-98eeb64c6a62.jpg',
    gallery: [
      'img/product-1553062407-98eeb64c6a62.jpg'
    ],
    capacity: '25L with dedicated padded laptop compartment',
    features: 'External USB charging port + Waterproof Oxford fabric',
    warranty: '12 Month Warranty',
    badge: 'DURABLE',
    featured: false,
    description: 'Cushioned air-mesh back padding, hidden zipper security, and water repellent material ideal for daily office commuting and travel.'
  },
  {
    id: 'acc-07',
    name: 'RGB Gaming Mechanical Keyboard (Blue Switches)',
    category: 'accessories',
    subcategory: 'peripherals',
    brand: 'Redragon',
    condition: 'New',
    price: 1999,
    mrp: 3999,
    discount: 50,
    rating: 4.7,
    reviewsCount: 168,
    image: 'img/product-1587829741301-dc798b83add3.jpg',
    gallery: [
      'img/product-1587829741301-dc798b83add3.jpg'
    ],
    switches: 'Dust-proof Clicky Blue Mechanical Switches',
    backlight: '18 Preset RGB Lighting Modes with brightness control',
    warranty: '12 Month Warranty',
    badge: 'MECHANICAL',
    featured: false,
    description: 'Tactile satisfying typing feedback with 100% anti-ghosting N-key rollover and solid aluminum top plate construction.'
  },
  {
    id: 'acc-08',
    name: '20,000mAh 22.5W Fast Charging Power Bank',
    category: 'accessories',
    subcategory: 'chargers',
    brand: 'Mi / Xiaomi',
    condition: 'New',
    price: 1699,
    mrp: 2999,
    discount: 43,
    rating: 4.8,
    reviewsCount: 410,
    image: 'img/product-1609592426861-c866858e72c5.jpg',
    gallery: [
      'img/product-1609592426861-c866858e72c5.jpg'
    ],
    capacity: '20,000mAh High-Density Lithium Polymer',
    output: '22.5W Two-way Quick Charge with Type-C input/output',
    warranty: '6 Month Warranty',
    badge: 'HEAVY DUTY',
    featured: false,
    description: 'Charges a typical smartphone 4 to 5 times. Features 12-layer advanced circuit chip protection and low current mode for earbuds.'
  },
  {
    id: 'acc-09',
    name: 'Active Noise Cancelling Wireless Earbuds (ANC)',
    category: 'accessories',
    subcategory: 'audio',
    brand: 'Realme Buds',
    condition: 'New',
    price: 1899,
    mrp: 3999,
    discount: 53,
    rating: 4.6,
    reviewsCount: 275,
    image: 'img/product-1590658268037-6bf12165a8df.jpg',
    gallery: [
      'img/product-1590658268037-6bf12165a8df.jpg'
    ],
    anc: '30dB Active Noise Cancellation + Transparency Mode',
    battery: '38 Hours Total Playback with Fast Charging',
    warranty: '12 Month Warranty',
    badge: 'ANC AUDIO',
    featured: false,
    description: 'Block out traffic and chatter with 30dB active noise cancellation. 12.4mm dynamic bass drivers for immersive punchy sound.'
  },
  {
    id: 'acc-10',
    name: 'Dual Fan High Performance Laptop Cooling Pad',
    category: 'accessories',
    subcategory: 'stands',
    brand: 'VANSH Pro',
    condition: 'New',
    price: 999,
    mrp: 2499,
    discount: 60,
    rating: 4.5,
    reviewsCount: 132,
    image: 'img/product-1527443224154-c4a3942d3acf.jpg',
    gallery: [
      'img/product-1527443224154-c4a3942d3acf.jpg'
    ],
    fans: '2x 140mm Whisper Quiet LED Fans (1200 RPM)',
    ports: 'Pass-through Dual USB Ports',
    warranty: '6 Month Warranty',
    badge: 'COOLING',
    featured: false,
    description: 'Drops laptop internal temperature by up to 12°C during intensive video rendering or gaming. Blue LED lighting and adjustable anti-skid baffles.'
  }
];

// ==========================================
// BLOG ARTICLES
// ==========================================
const BLOG_POSTS = [
  {
    id: 'blog-01',
    title: 'Refurbished vs Second-Hand Laptop: Key Differences You Must Know',
    category: 'Buying Guide',
    date: 'Sep 12, 2026',
    readTime: '5 min read',
    author: {
      name: 'Vansh Sharma',
      role: 'Lead Hardware Specialist',
      avatar: 'img/product-1588872657578-7efd1f1555ed.jpg'
    },
    image: 'img/product-1593642632823-8f785ba67e45.jpg',
    excerpt: 'Second-hand electronics carry unknown risks, whereas certified refurbished laptops undergo multi-point testing, component servicing, and include structured warranties.',
    content: `
      <h2>Introduction: The Growing Dilemma for Smart Buyers</h2>
      <p>When searching for a budget-friendly computing device, buyers frequently encounter two terms: <strong>"Second-Hand" (or Used)</strong> and <strong>"Certified Refurbished"</strong>. While both options offer substantial savings compared to brand-new electronics, they represent completely different quality standards, reliability levels, and post-purchase protections.</p>
      
      <div class="my-6 p-5 rounded-2xl bg-blue-50 border border-blue-200">
        <h4 class="font-bold text-blue-900 text-sm mb-1 flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Key Takeaway in 10 Seconds</h4>
        <p class="text-xs text-blue-800 leading-relaxed">Second-hand devices are sold "as-is" by individual sellers without testing or warranty. Certified refurbished units undergo industrial diagnostics, component replacements (like fresh SSDs and high-capacity batteries), physical sanitization, and are backed by up to a 12-month replacement warranty with valid GST invoices.</p>
      </div>

      <h2>Direct Comparison: Refurbished vs Second-Hand</h2>
      <div class="overflow-x-auto my-6">
        <table class="w-full text-left text-xs border border-slate-200 rounded-xl overflow-hidden">
          <thead class="bg-slate-900 text-white">
            <tr>
              <th class="p-3">Feature</th>
              <th class="p-3">Certified Refurbished (VANSH IT)</th>
              <th class="p-3">Second-Hand (P2P Marketplaces)</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
            <tr>
              <td class="p-3 font-semibold">Testing Protocol</td>
              <td class="p-3 text-emerald-700 font-bold">20-Point Bench Diagnostics</td>
              <td class="p-3 text-rose-600">None (Sold as-is)</td>
            </tr>
            <tr>
              <td class="p-3 font-semibold">Battery Health</td>
              <td class="p-3 text-emerald-700 font-bold">Guaranteed 80%+ / Fresh Cell</td>
              <td class="p-3 text-rose-600">Degraded (Often 30-50%)</td>
            </tr>
            <tr>
              <td class="p-3 font-semibold">Warranty Cover</td>
              <td class="p-3 text-emerald-700 font-bold">Up to 12 Months Structured</td>
              <td class="p-3 text-rose-600">Zero / Disappears after payment</td>
            </tr>
            <tr>
              <td class="p-3 font-semibold">GST Invoice</td>
              <td class="p-3 text-emerald-700 font-bold">100% Legitimate Tax Invoice</td>
              <td class="p-3 text-rose-600">No invoice / Ownership risks</td>
            </tr>
            <tr>
              <td class="p-3 font-semibold">Live Inspection</td>
              <td class="p-3 text-emerald-700 font-bold">Live Video Call QC Available</td>
              <td class="p-3 text-slate-500">Unreliable meetup spots</td>
            </tr>
          </tbody>
        </table>
      </div>

      <h2>The 20-Point Testing Advantage</h2>
      <p>At VANSH IT & COMM, refurbished business-grade laptops (such as Dell Latitude, Lenovo ThinkPad, and HP EliteBook) are engineered to withstand continuous heavy workloads. Our engineering team conducts thermal stress tests, memory error scans via MemTest86, screen dead-pixel audits, keyboard matrix verification, and port integrity checks before any laptop receives the certified badge.</p>

      <h2>Conclusion: Which One Should You Choose?</h2>
      <p>If you are a student, programmer, remote professional, or small business owner looking for a machine that delivers consistent daily reliability with zero risk of sudden component failure, <strong>Certified Refurbished</strong> is undoubtedly the superior, cost-effective investment.</p>
    `
  },
  {
    id: 'blog-02',
    title: 'Top 5 Refurbished Laptops Under ₹25,000 for Programmers & Students',
    category: 'Recommendations',
    date: 'Sep 08, 2026',
    readTime: '6 min read',
    author: {
      name: 'Rohan Verma',
      role: 'Senior Systems Architect',
      avatar: 'img/product-1593642632823-8f785ba67e45.jpg'
    },
    image: 'img/product-1588872657578-7efd1f1555ed.jpg',
    excerpt: 'Discover why business laptops like ThinkPad T480 and Dell Latitude 5420 easily outperform brand-new entry-level consumer laptops at the same price point.',
    content: `
      <h2>Why Brand-New ₹25,000 Consumer Laptops Fall Short</h2>
      <p>Entry-level brand-new laptops priced around ₹25,000 usually ship with low-power dual-core Celeron or Athlon processors, flimsy plastic chassis, and soldered 4GB RAM that struggles with modern Windows 11 updates, VS Code, and multiple Chrome tabs.</p>
      
      <p>In contrast, enterprise laptops originally priced between ₹80,000 to ₹1,40,000 are built with magnesium-alloy bodies, spill-resistant tactile keyboards, military-grade durability (MIL-STD 810G), and easily upgradeable dual-channel RAM.</p>

      <h2>Our Top 5 Budget Powerhouse Picks</h2>
      
      <h3>1. Lenovo ThinkPad T480 / T490 (The Developer's Holy Grail)</h3>
      <p>Featuring an industry-leading tactile keyboard, dual hot-swappable battery bridge system, Intel Quad-Core i5 8th Gen, and support for up to 32GB RAM and 1TB NVMe SSD.</p>

      <h3>2. Dell Latitude 5420 / 7400 (Ultra-Slim Workhorse)</h3>
      <p>Equipped with a crisp Full HD Anti-Glare IPS display, responsive precision glass trackpad, Thunderbolt connectivity, and whisper-quiet cooling fans.</p>

      <h3>3. HP EliteBook 840 G6 (All-Aluminum Executive)</h3>
      <p>Full CNC aluminum unibody, Bang & Olufsen tuned quad-speakers, privacy camera shutter, and premium enterprise aesthetics.</p>

      <h3>4. Dell Latitude 3310 (Compact Student Travel Machine)</h3>
      <p>13.3-inch ultra-portable form factor, rubberized protective edges for drop resistance, lightweight 1.3kg footprint, and great 6+ hour battery backup.</p>

      <h3>5. Lenovo ThinkPad L13 Yoga (Touchscreen & Stylus Support)</h3>
      <p>360-degree convertible 2-in-1 hinge, active stylus support for note-taking, sketching, and PDF annotations.</p>
    `
  },
  {
    id: 'blog-03',
    title: 'How to Properly Check a Pre-Owned iPhone Before Buying',
    category: 'Mobile Guide',
    date: 'Aug 29, 2026',
    readTime: '4 min read',
    author: {
      name: 'Priya Mehta',
      role: 'Mobile Hardware Diagnostics',
      avatar: 'img/product-1511707171634-5f897ff02aa9.jpg'
    },
    image: 'img/product-1511707171634-5f897ff02aa9.jpg',
    excerpt: 'Essential checklist: True Tone functionality, battery health cycles, Face ID infrared sensor check, camera lens alignment, and carrier lock verification.',
    content: `
      <h2>The Critical iPhone Inspection Protocol</h2>
      <p>Purchasing a pre-owned iPhone is one of the best ways to enjoy iOS ecosystem fluidity and class-leading video recording at 40% to 60% off MSRP. However, you must verify key hardware signatures before closing the deal.</p>

      <h3>1. True Tone & OEM Screen Verification</h3>
      <p>Open Control Center, press and hold the brightness slider, and ensure the <strong>True Tone</strong> toggle is present and functional. If True Tone is missing, the screen has likely been replaced with a non-OEM duplicate panel.</p>

      <h3>2. Face ID & TrueDepth Infrared Camera</h3>
      <p>Go to Settings > Face ID & Passcode. Set up Face ID and test unlocking at various angles. Face ID cannot be easily repaired by third-party shops if the infrared flood illuminator has moisture damage.</p>

      <h3>3. Battery Health & Charge Cycle Count</h3>
      <p>Verify that Battery Maximum Capacity is at least 85%+ in Settings. All VANSH IT & COMM smartphones are strictly certified above 85% battery health with genuine Apple diagnostics.</p>

      <h3>4. Carrier Lock & iCloud Activation</h3>
      <p>Always verify under Settings > General > About that <em>"Carrier Lock: No SIM restrictions"</em> is displayed and sign into your own Apple ID on the spot.</p>
    `
  },
  {
    id: 'blog-04',
    title: '8GB vs 16GB RAM in 2026: Is 8GB Still Enough for Modern Workloads?',
    category: 'Hardware Specs',
    date: 'Aug 20, 2026',
    readTime: '5 min read',
    author: {
      name: 'Vansh Sharma',
      role: 'Lead Hardware Specialist',
      avatar: 'img/product-1588872657578-7efd1f1555ed.jpg'
    },
    image: 'img/product-1562976540-1502c2145186.jpg',
    excerpt: 'We benchmarked everyday applications, browser tab consumption, and multitasking to help you decide if upgrading to 16GB RAM is worth the investment.',
    content: `
      <h2>The Reality of Modern Memory Consumption</h2>
      <p>Modern operating systems like Windows 11 consume roughly 3.5GB to 4.2GB of RAM on cold boot just to run background services, antivirus, and window managers. Adding 10 to 15 browser tabs, Slack, WhatsApp, and Microsoft Excel quickly pushes memory usage past 7.5GB.</p>

      <h2>When 8GB Is Sufficient:</h2>
      <ul class="list-disc list-inside space-y-1 my-3 text-slate-700">
        <li>Web browsing with 5-8 open tabs</li>
        <li>Microsoft Word, PowerPoint, and basic Excel spreadsheets</li>
        <li>Online video streaming (YouTube, Netflix, Zoom classes)</li>
        <li>Casual accounting software (Tally Prime)</li>
      </ul>

      <h2>When You Need 16GB RAM:</h2>
      <ul class="list-disc list-inside space-y-1 my-3 text-slate-700">
        <li>Software development (VS Code, Docker containers, Node.js servers, Android Studio)</li>
        <li>Graphic design & video editing (Adobe Photoshop, Illustrator, Premiere Pro)</li>
        <li>Heavy multitasking with 30+ browser tabs and CRM software</li>
        <li>Esports gaming (Valorant, CS:GO, GTA V)</li>
      </ul>

      <div class="p-4 rounded-xl bg-slate-100 border border-slate-200 my-4">
        <strong>VANSH IT Pro Tip:</strong> Most of our refurbished business laptops feature dual accessible SO-DIMM slots, allowing you to upgrade from 8GB to 16GB or 32GB at any time for a nominal fee.
      </div>
    `
  },
  {
    id: 'blog-05',
    title: 'SSD vs HDD: Why Replacing Your Old Hard Drive Feels Like Buying a New PC',
    category: 'Performance',
    date: 'Aug 14, 2026',
    readTime: '4 min read',
    author: {
      name: 'Rohan Verma',
      role: 'Senior Systems Architect',
      avatar: 'img/product-1593642632823-8f785ba67e45.jpg'
    },
    image: 'img/product-1597872200969-2b65d56bd16b.jpg',
    excerpt: 'Find out how NVMe and SATA solid state drives achieve 5x to 25x read/write speed improvements over spinning disk hard drives.',
    content: `
      <h2>The Mechanical Bottleneck of Old Laptops</h2>
      <p>Traditional Hard Disk Drives (HDDs) rely on physical magnetic platters spinning at 5400 or 7200 RPM and a mechanical actuator arm reading data. This limits sequential read speeds to roughly 80–120 MB/s, with severe latency during random file access.</p>

      <h2>Solid State Storage (SSD) Transformation</h2>
      <p>Solid State Drives utilize high-speed flash NAND memory with zero moving parts. SATA SSDs deliver speeds up to 550 MB/s (5x faster), while PCIe NVMe SSDs achieve blisteringly fast 2,500 to 7,000 MB/s.</p>

      <h2>Real World Benefits:</h2>
      <ul class="list-disc list-inside space-y-1 my-3 text-slate-700">
        <li><strong>Boot Times:</strong> From 90+ seconds on HDD down to 8–12 seconds on SSD.</li>
        <li><strong>App Launch:</strong> Instantaneous launch for browsers, Photoshop, and IDEs.</li>
        <li><strong>Zero Noise & Shock Resistance:</strong> Drops and vibrations won't cause head crashes or data loss.</li>
        <li><strong>Energy Efficiency:</strong> 30% longer laptop battery backup.</li>
      </ul>
    `
  },
  {
    id: 'blog-06',
    title: 'Common Laptop Screen Problems: Can It Be Repaired or Replaced?',
    category: 'Repair Advice',
    date: 'Aug 02, 2026',
    readTime: '5 min read',
    author: {
      name: 'Priya Mehta',
      role: 'Mobile Hardware Diagnostics',
      avatar: 'img/product-1511707171634-5f897ff02aa9.jpg'
    },
    image: 'img/product-1588872657578-7efd1f1555ed.jpg',
    excerpt: 'Flickering displays, vertical lines, black screens or cracked glass: learn the root causes, repair feasibility, and typical service timelines.',
    content: `
      <h2>Diagnosing Laptop Display Malfunctions</h2>
      <p>Laptop display issues are among the most common repair inquiries we receive at our service center. Understanding whether your issue requires an EDP flex cable reseating or a full LCD panel replacement helps you budget appropriately.</p>

      <h3>1. Vertical or Horizontal Color Lines</h3>
      <p>Usually caused by damaged COF (Chip-on-Film) bonding or physical pressure damage to the TFT matrix. Requires a genuine panel replacement.</p>

      <h3>2. Display Flickering When Moving Hinge</h3>
      <p>Typically caused by a loose or crimped 30-pin/40-pin EDP video flex ribbon passing through the laptop hinge mechanism. Can frequently be repaired or replaced without changing the LCD panel itself.</p>

      <h3>3. Dim Screen / Faint Image (No Backlight)</h3>
      <p>Caused by a blown motherboard backlight fuse, damaged LED driver IC, or faulty panel circuitry.</p>

      <p>Need your laptop diagnosed? Visit our <a href="{{ route('repair') }}" class="text-blue-600 font-bold underline">Repair Services page</a> to book a free diagnostic test with genuine parts warranty.</p>
    `
  }
];

// ==========================================
// FREQUENTLY ASKED QUESTIONS (FAQS)
// ==========================================
const FAQS_DATA = [
  {
    category: 'General & Products',
    question: 'What is a refurbished laptop and how does it differ from second-hand?',
    answer: 'A refurbished device is a previously owned or open-box device that has undergone professional hardware testing, thorough internal cleaning, thermal paste re-application, OS certification, and cosmetic grading. Unlike informal peer-to-peer second-hand sales, VANSH IT & COMM refurbished devices come tested across 20 points, with genuine chargers and warranty support.'
  },
  {
    category: 'General & Products',
    question: 'How are devices tested before being dispatched?',
    answer: 'Every laptop and phone undergoes our 20-Point Quality Diagnostic check covering Motherboard health, CPU/GPU stress test, RAM integrity, SSD read/write speeds & health percentage, keyboard keys & trackpad, screen dead pixels & backlight bleed, webcam/mic, ports/Thunderbolt connectivity, Wi-Fi/Bluetooth signals, and battery cycle retention.'
  },
  {
    category: 'Warranty & Invoices',
    question: 'Is warranty included and what does it cover?',
    answer: 'Yes! Most refurbished laptops and flagship smartphones include up to 12 Months Warranty (as explicitly specified on the product page), and budget or accessory devices carry 6 to 12 months warranty. It covers internal hardware malfunctions, motherboard issues, and component failures under standard normal usage.'
  },
  {
    category: 'Warranty & Invoices',
    question: 'Will I receive a GST Tax Invoice with my purchase?',
    answer: 'Yes, 100% of purchases include an authentic tax invoice with GST breakdown, which businesses can utilize for claiming eligible input tax credits.'
  },
  {
    category: 'Shipping & Payment',
    question: 'Do you deliver across India?',
    answer: 'Yes, we provide insured delivery across 19,000+ pincodes across India through reputed tier-1 courier partners (BlueDart, Delhivery, DTDC) with secure tamper-evident multi-layer bubble packaging.'
  },
  {
    category: 'Shipping & Payment',
    question: 'What payment options and COD options are available?',
    answer: 'We support UPI (GPay, PhonePe, Paytm), Credit & Debit Cards (Visa, MasterCard, RuPay), Net Banking, and Cash on Delivery (COD) on eligible pin codes.'
  },
  {
    category: 'Exchange & Repair',
    question: 'Can I exchange my old laptop or phone for an upgrade?',
    answer: 'Absolutely. You can use our online Exchange Calculator on the Exchange page to receive an instant estimated trade-in value, which can be applied directly towards purchasing your next upgraded device.'
  },
  {
    category: 'Exchange & Repair',
    question: 'How do I book a laptop or mobile repair service?',
    answer: 'Visit our dedicated Repair page, pick your device type and issue (such as broken screen, dead battery, or slow performance), and submit the booking form. Our technical team will reach out to confirm diagnostic steps and pickup or drop-off timing.'
  },
  {
    category: 'Returns & Inspection',
    question: 'Can I check actual photos or video of the refurbished device before buying?',
    answer: 'Yes! You can click the "Request Product Video" button on any product detail page or message our team to receive real-time photos and video of the exact device before dispatch.'
  }
];

// ==========================================
// SAMPLE REVIEWS (Demo Customer Feedback)
// ==========================================
const REVIEWS_DATA = [
  {
    name: 'Rajesh Sharma',
    city: 'New Delhi',
    rating: 5,
    product: 'Lenovo ThinkPad T480',
    date: '2 weeks ago',
    badge: 'Verified Buyer',
    comment: 'Received the ThinkPad in almost brand new condition. The keyboard is crisp, battery gives over 5 hours easily, and booting takes just 8 seconds. Saved over ₹50,000 compared to brand new!'
  },
  {
    name: 'Pooja Verma',
    city: 'Bengaluru',
    rating: 5,
    product: 'Dell Latitude 5420',
    date: '1 month ago',
    badge: 'Verified Buyer',
    comment: 'I was hesitant about buying refurbished online, but VANSH IT & COMM delivered with genuine GST bill, 12 month warranty card, and original Dell charger. Highly recommended for remote workers.'
  },
  {
    name: 'Amit Patel',
    city: 'Ahmedabad',
    rating: 5,
    product: 'Apple iPhone 13 128GB',
    date: '3 weeks ago',
    badge: 'Verified Buyer',
    comment: 'Phone arrived in mint condition with 91% battery health. True Tone and Face ID work flawlessly. Excellent packaging and next day dispatch.'
  },
  {
    name: 'Karthik Raman',
    city: 'Chennai',
    rating: 5,
    product: '65W GaN Fast Charger',
    date: '1 week ago',
    badge: 'Verified Buyer',
    comment: 'Charges both my MacBook Air and Android phone simultaneously without getting warm. Very compact for travel.'
  }
];

// ==========================================
// COUPON CODES (Demo)
// ==========================================
const COUPONS_DATA = {
  'VANSH10': {
    code: 'VANSH10',
    type: 'percent',
    value: 10,
    minOrder: 1000,
    description: '10% instant discount on all electronics'
  },
  'WELCOME500': {
    code: 'WELCOME500',
    type: 'flat',
    value: 500,
    minOrder: 5000,
    description: 'Flat ₹500 discount on your first order'
  }
};

// Resolve relative image paths (img/xyz.jpg) to full asset URLs
const resolveImg = (p) => {
  if (!p || /^(https?:)?\/\//.test(p) || p.startsWith('/') || p.startsWith('data:')) return p;
  return `${window.ASSET_BASE || '/assets'}/${p}`;
};

PRODUCTS_DATA.forEach(p => {
  p.image = resolveImg(p.image);
  p.gallery = (p.gallery || []).map(resolveImg);
});

BLOG_POSTS.forEach(b => {
  b.image = resolveImg(b.image);
  if (b.author) b.author.avatar = resolveImg(b.author.avatar);
});