/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : SQL Server
 Source Server Version : 12002000
 Source Host           : USER-PC\SQLEXPRESS:1433
 Source Catalog        : ems
 Source Schema         : dbo

 Target Server Type    : SQL Server
 Target Server Version : 12002000
 File Encoding         : 65001

 Date: 20/09/2019 15:33:16
*/


-- ----------------------------
-- Table structure for item_tvi
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[item_tvi]') AND type IN ('U'))
	DROP TABLE [dbo].[item_tvi]
GO

CREATE TABLE [dbo].[item_tvi] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [project_id] int  NULL,
  [nama] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [satuan] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [harga_satuan] int  NULL,
  [keterangan] varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [delete] bit  NULL,
  [is_channel] bit  NULL
)
GO

ALTER TABLE [dbo].[item_tvi] SET (LOCK_ESCALATION = TABLE)
GO

EXEC sp_addextendedproperty
'MS_Description', N'0 internet, 1 tv, 3 semua',
'SCHEMA', N'dbo',
'TABLE', N'item_tvi',
'COLUMN', N'is_channel'
GO


-- ----------------------------
-- Primary Key structure for table item_tvi
-- ----------------------------
ALTER TABLE [dbo].[item_tvi] ADD CONSTRAINT [PK__item_tvi__3213E83F35653B85] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO

