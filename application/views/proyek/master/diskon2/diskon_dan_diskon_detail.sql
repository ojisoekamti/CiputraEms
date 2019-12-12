USE [ciputraEms]
GO
/****** Object:  Table [dbo].[diskon]    Script Date: 28/01/2019 11:23:47 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[diskon](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[gol_diskon_id] [int] NOT NULL,
	[product_category_id] [int] NOT NULL,
	[description] [varchar](255) NULL,
	[active] [bit] NOT NULL,
	[delete] [bit] NULL,
 CONSTRAINT [PK_diskon] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[diskon_detail]    Script Date: 28/01/2019 11:23:47 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[diskon_detail](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[diskon_id] [int] NOT NULL,
	[service_id] [int] NULL,
	[parameter_id] [int] NULL,
	[nilai] [int] NULL,
	[active] [bit] NULL,
	[delete] [bit] NULL,
	[flag_umum_event] [bit] NULL,
	[coa_mapping_id_diskon] [int] NULL,
 CONSTRAINT [PK_diskon_detail] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
