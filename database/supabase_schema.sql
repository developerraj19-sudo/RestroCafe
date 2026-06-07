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
