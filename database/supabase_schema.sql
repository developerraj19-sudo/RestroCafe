-- =============================================================
--  RestroCafe - Database Schema (PostgreSQL/Supabase)
-- =============================================================

-- =============================================================
--  CORE RESTAURANT / ORDERING TABLES
-- =============================================================

CREATE TABLE tbl_user (
  ID                    SERIAL        PRIMARY KEY,
  u_id                  VARCHAR(40)   NOT NULL UNIQUE,
  user_name             VARCHAR(150)  DEFAULT NULL,
  table_no              INT           DEFAULT NULL,
  mobile                VARCHAR(20)   DEFAULT NULL,
  password              VARCHAR(255)  DEFAULT NULL,
  raw_pass              VARCHAR(255)  DEFAULT NULL,
  email                 VARCHAR(190)  DEFAULT NULL,
  user_activation_code  VARCHAR(190)  DEFAULT NULL,
  user_otp              VARCHAR(20)   DEFAULT NULL,
  branchid              INT           DEFAULT NULL
);

CREATE INDEX idx_table_no ON tbl_user (table_no);
CREATE INDEX idx_mobile ON tbl_user (mobile);

CREATE TABLE tbl_items (
  item_id     VARCHAR(40)    PRIMARY KEY,
  item_name   VARCHAR(190)   NOT NULL,
  item_desc   TEXT           DEFAULT NULL,
  categories  VARCHAR(100)   DEFAULT NULL,
  veg         VARCHAR(5)     DEFAULT 'YES',
  price       DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
  image       VARCHAR(255)   DEFAULT NULL
);

CREATE INDEX idx_categories ON tbl_items (categories);

CREATE TABLE tbl_orders (
  order_id     VARCHAR(40)   PRIMARY KEY,
  u_id         VARCHAR(40)   NOT NULL REFERENCES tbl_user(u_id) ON DELETE CASCADE,
  item_id      VARCHAR(40)   NOT NULL REFERENCES tbl_items(item_id),
  o_qty        INT           NOT NULL DEFAULT 1,
  ostatus      VARCHAR(10)   NOT NULL DEFAULT 'NO',
  dateandtime  VARCHAR(20)   DEFAULT NULL
);

CREATE INDEX idx_u_id ON tbl_orders (u_id);
CREATE INDEX idx_item_id ON tbl_orders (item_id);
CREATE INDEX idx_ostatus ON tbl_orders (ostatus);

CREATE TABLE tbl_emp (
  staff_id  SERIAL        PRIMARY KEY,
  username  VARCHAR(100)  NOT NULL UNIQUE,
  password  VARCHAR(255)  NOT NULL
);

CREATE TABLE tbl_config (
  id           SERIAL        PRIMARY KEY,
  site_title   VARCHAR(190)  DEFAULT NULL,
  tag_line     VARCHAR(255)  DEFAULT NULL,
  contact      VARCHAR(50)   DEFAULT NULL,
  email        VARCHAR(190)  DEFAULT NULL,
  address      VARCHAR(255)  DEFAULT NULL,
  logo         VARCHAR(255)  DEFAULT NULL,
  branchid     INT           DEFAULT NULL
);

-- =============================================================
--  ACCOUNTING / GST BILLING TABLES
-- =============================================================

CREATE TABLE salemast (
  ID           SERIAL         PRIMARY KEY,
  PurNum       INT            DEFAULT NULL,
  PurDate      DATE           DEFAULT NULL,
  refNo        VARCHAR(50)    DEFAULT NULL,
  PurType      VARCHAR(20)    DEFAULT NULL,
  SupNo        VARCHAR(50)    DEFAULT NULL,
  NetAmount    DECIMAL(14,2)  DEFAULT 0.00,
  roundoff     DECIMAL(10,2)  DEFAULT 0.00,
  GrandTot     DECIMAL(14,2)  DEFAULT 0.00,
  Notes        VARCHAR(255)   DEFAULT NULL,
  totvat       DECIMAL(14,2)  DEFAULT 0.00,
  VehNo        VARCHAR(50)    DEFAULT NULL,
  tMode        INT            DEFAULT 1,
  totSales     DECIMAL(14,2)  DEFAULT 0.00,
  totDisc      DECIMAL(14,2)  DEFAULT 0.00,
  totQty       DECIMAL(14,3)  DEFAULT 0.000,
  custDesc     VARCHAR(190)   DEFAULT NULL,
  custAdd1     VARCHAR(190)   DEFAULT NULL,
  custAdd2     VARCHAR(190)   DEFAULT NULL,
  custTin      VARCHAR(30)    DEFAULT NULL,
  PurTime      TIME           DEFAULT NULL,
  LastModBy    VARCHAR(100)   DEFAULT NULL,
  LastModDate  TIMESTAMP      DEFAULT NULL,
  Active       CHAR(1)        DEFAULT 'A',
  PartyType    INT            DEFAULT 1,
  SalesMan     VARCHAR(50)    DEFAULT 'DIRECT',
  VouchCat     CHAR(1)        DEFAULT 'I',
  TaxRegType   VARCHAR(20)    DEFAULT NULL,
  CustState    VARCHAR(50)    DEFAULT NULL,
  CustMob      VARCHAR(20)    DEFAULT NULL,
  InvoiceNo    VARCHAR(50)    DEFAULT NULL,
  TranType     VARCHAR(30)    DEFAULT NULL,
  totSGST      DECIMAL(14,2)  DEFAULT 0.00,
  totCGST      DECIMAL(14,2)  DEFAULT 0.00,
  totIGST      DECIMAL(14,2)  DEFAULT 0.00,
  BranchID     INT            DEFAULT NULL
);

CREATE INDEX idx_branch_invoice ON salemast (BranchID, InvoiceNo);
CREATE INDEX idx_purdate ON salemast (PurDate);

CREATE TABLE saledet (
  LineID     SERIAL         PRIMARY KEY,
  ID         INT            NOT NULL REFERENCES salemast(ID) ON DELETE CASCADE,
  ProdNo     VARCHAR(50)    DEFAULT NULL,
  SNo        INT            DEFAULT NULL,
  Uom        VARCHAR(20)    DEFAULT NULL,
  Qty        DECIMAL(14,3)  DEFAULT 0.000,
  Rate       DECIMAL(14,2)  DEFAULT 0.00,
  Amount     DECIMAL(14,2)  DEFAULT 0.00,
  DiscVal    DECIMAL(14,2)  DEFAULT 0.00,
  St         DECIMAL(14,2)  DEFAULT 0.00,
  MRP        DECIMAL(14,2)  DEFAULT 0.00,
  ARate      DECIMAL(14,2)  DEFAULT 0.00,
  IGST_Rate  DECIMAL(6,2)   DEFAULT 0.00,
  SGST_Rate  DECIMAL(6,2)   DEFAULT 0.00,
  CGST_Rate  DECIMAL(6,2)   DEFAULT 0.00,
  IGST_Amt   DECIMAL(14,2)  DEFAULT 0.00,
  SGST_Amt   DECIMAL(14,2)  DEFAULT 0.00,
  CGST_Amt   DECIMAL(14,2)  DEFAULT 0.00,
  taxCode    VARCHAR(20)    DEFAULT NULL,
  tMode      INT            DEFAULT 1
);

CREATE INDEX idx_saledet_master ON saledet (ID);
CREATE INDEX idx_saledet_prod ON saledet (ProdNo);

CREATE TABLE salevouch (
  VouchID    SERIAL         PRIMARY KEY,
  ID         INT            NOT NULL REFERENCES salemast(ID) ON DELETE CASCADE,
  ActNo      VARCHAR(50)    DEFAULT NULL,
  DrAmount   DECIMAL(14,2)  DEFAULT 0.00,
  CrAmount   DECIMAL(14,2)  DEFAULT 0.00,
  Amount     DECIMAL(14,2)  DEFAULT 0.00,
  Tax        DECIMAL(14,2)  DEFAULT 0.00,
  DON        VARCHAR(50)    DEFAULT NULL,
  TaxSlabID  INT            DEFAULT NULL
);

CREATE INDEX idx_salevouch_master ON salevouch (ID);

CREATE TABLE prodmast (
  ProdNo    VARCHAR(50)    PRIMARY KEY,
  ProdName  VARCHAR(190)   DEFAULT NULL,
  CurStock  DECIMAL(14,3)  DEFAULT 0.000,
  VatAmt    DECIMAL(14,2)  DEFAULT 0.00,
  SPkg      VARCHAR(50)    DEFAULT NULL
);

CREATE TABLE acmast (
  ActNo    VARCHAR(50)   PRIMARY KEY,
  ActName  VARCHAR(190)  DEFAULT NULL,
  GNo      INT           DEFAULT NULL
);

CREATE INDEX idx_gno ON acmast (GNo);

CREATE TABLE taxslab (
  ID        SERIAL        PRIMARY KEY,
  TotalTax  DECIMAL(6,2)  DEFAULT 0.00
);

CREATE TABLE actheadmap (
  ID         SERIAL   PRIMARY KEY,
  TaxSlabID  INT      DEFAULT NULL
);

CREATE INDEX idx_taxslab ON actheadmap (TaxSlabID);

CREATE TABLE cashparties (
  id     SERIAL        PRIMARY KEY,
  Party  VARCHAR(190)  DEFAULT NULL,
  MobNo  VARCHAR(20)   DEFAULT NULL
);

CREATE INDEX idx_mobno ON cashparties (MobNo);

CREATE TABLE vehmast (
  VehNo  VARCHAR(50)   PRIMARY KEY,
  Owner  VARCHAR(190)  DEFAULT NULL
);

-- Default admin staff login (password hash is for: admin123).
INSERT INTO tbl_emp (username, password)
VALUES ('admin', '$2y$10$3/A.8M0d7dC5.rO.0Q5XG.r/5aP/M6V5hP2S.Q7uTz5mB6bK7QJ.a');
-- =============================================================
-- RestroCafe - Seed Data for Menu Items
-- Copy and paste this entirely into the Supabase SQL Editor
-- =============================================================

INSERT INTO tbl_items (item_id, item_name, item_desc, categories, veg, price, image) VALUES 
('item_101', 'Butter Chicken', 'Creamy and rich tomato-based chicken curry', 'Main Course', 'NO', 350.00, 'butter_chicken.png'),
('item_102', 'Butter Roti', 'Tandoori wheat flatbread brushed with butter', 'Breads', 'YES', 25.00, 'butter_roti.png'),
('item_103', 'Chicken Tikka', 'Spiced chicken chunks roasted in tandoor', 'Starters', 'NO', 250.00, 'chicken_tikka.png'),
('item_104', 'Chicken Wings', 'Crispy fried chicken wings with spicy sauce', 'Starters', 'NO', 220.00, 'chicken_wings.png'),
('item_105', 'Cold Coffee', 'Refreshing blended iced coffee', 'Beverages', 'YES', 120.00, 'cold_coffee.png'),
('item_106', 'Crispy Corn', 'Fried sweet corn kernels tossed in spices', 'Starters', 'YES', 150.00, 'crispy_corn.png'),
('item_107', 'Dal Makhani', 'Slow-cooked black lentils in creamy butter sauce', 'Main Course', 'YES', 220.00, 'dal_makhani.png'),
('item_108', 'Fish Amritsari', 'Crispy spiced battered fish fry', 'Starters', 'NO', 320.00, 'fish_amritsari.png'),
('item_109', 'Fresh Lime Soda', 'Sweet and salty refreshing lemon soda', 'Beverages', 'YES', 80.00, 'Fresh Lime Soda.jpg'),
('item_110', 'Garlic Naan', 'Soft flatbread topped with garlic and butter', 'Breads', 'YES', 60.00, 'garlic_naan.png'),
('item_111', 'Gulab Jamun', 'Sweet milk-solid balls soaked in sugar syrup', 'Desserts', 'YES', 90.00, 'gulab_jamun.png'),
('item_112', 'Hara Bhara Kebab', 'Healthy spinach, peas, and potato patties', 'Starters', 'YES', 180.00, 'hara_bhara_kebab.png'),
('item_113', 'Kulfi Falooda', 'Traditional Indian ice cream dessert', 'Desserts', 'YES', 140.00, 'kulfi_falooda.png'),
('item_114', 'Mango Lassi', 'Sweet yogurt drink blended with fresh mango', 'Beverages', 'YES', 110.00, 'mango-lassi-drink.png'),
('item_115', 'Masala Chai', 'Indian spiced milk tea', 'Beverages', 'YES', 40.00, 'Masala Chai.png'),
('item_116', 'Mixed Pickle', 'Spicy assorted Indian pickle', 'Sides', 'YES', 30.00, 'Mixed Pickle.png'),
('item_117', 'Mutton Biryani', 'Aromatic basmati rice cooked with spiced mutton', 'Main Course', 'NO', 450.00, 'mutton_biryani.png'),
('item_118', 'Palak Paneer', 'Cottage cheese cubes in a creamy spinach gravy', 'Main Course', 'YES', 260.00, 'palak_paneer.png'),
('item_119', 'Paneer Butter Masala', 'Cottage cheese in rich buttery tomato gravy', 'Main Course', 'YES', 280.00, 'paneer_butter_masala.png'),
('item_120', 'Paneer Tikka', 'Grilled marinated cottage cheese chunks', 'Starters', 'YES', 220.00, 'paneer_tikka.png'),
('item_121', 'Papad Platter', 'Assortment of roasted and fried papads', 'Sides', 'YES', 70.00, 'Papad Platter.png'),
('item_122', 'Raita', 'Cooling yogurt dip with spices', 'Sides', 'YES', 60.00, 'Raita.png'),
('item_123', 'Rasgulla', 'Spongy cottage cheese balls in sugar syrup', 'Desserts', 'YES', 100.00, 'rasgulla.png'),
('item_124', 'Seekh Kebab', 'Minced meat skewers cooked in tandoor', 'Starters', 'NO', 300.00, 'seekh_kebab.png'),
('item_125', 'Shahi Paneer', 'Royal cottage cheese curry in cashew gravy', 'Main Course', 'YES', 290.00, 'shahi_paneer.png'),
('item_126', 'Stuffed Paratha', 'Whole wheat flatbread stuffed with spiced potatoes', 'Breads', 'YES', 80.00, 'stuffed_paratha.png'),
('item_127', 'Veg Biryani', 'Aromatic spiced rice mixed with vegetables', 'Main Course', 'YES', 240.00, 'veg_biryani.png'),
('item_128', 'Veg Spring Rolls', 'Crispy fried rolls stuffed with vegetables', 'Starters', 'YES', 160.00, 'veg_spring_rolls.png'),
('item_129', 'Virgin Mojito', 'Mint and lime mocktail', 'Beverages', 'YES', 130.00, 'Virgin Mojito.png');
