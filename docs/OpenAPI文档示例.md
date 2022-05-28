


## OpenAPI 文档示例

```json
{
  "components": {
    "securitySchemes": []
  },
  "externalDocs": [],
  "info": {
    "title": "项目名称",
    "description": "项目描述",
    "version": "0.0.0",
    "termsOfService": "http://localhost/service.html",
    "contact": {
      "name": "联系人",
      "url": "http://localhost/contact.html",
      "email": "example@example.com"
    },
    "license": {
      "name": "API许可",
      "url": "http://localhost/license.html"
    }
  },
  "openapi": "3.0.3",
  "security": [],
  "servers": [],
  "tags": [],
  "paths": {
    "/api/example/test": {
      "get": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      },
      "post": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      },
      "put": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      },
      "patch": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      },
      "delete": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      },
      "head": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      },
      "options": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      }
    },
    "/test1": {
      "get": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false,
        "requestBody": {
          "content": {
            "multipart/form-data": {
              "schema": {
                "required": [
                  "field2"
                ],
                "type": "object",
                "properties": {
                  "file": {
                    "type": "file"
                  },
                  "field1": {
                    "type": "integer"
                  },
                  "field2": {
                    "type": "boolean"
                  }
                }
              }
            },
            "application/json": {
              "schema": {
                "required": [],
                "type": "object",
                "properties": {
                  "field1": {
                    "type": "string"
                  },
                  "field2": {
                    "type": "string"
                  }
                }
              }
            }
          },
          "required": false
        }
      }
    },
    "/api/wp/v1/options": {
      "get": {
        "tags": [
          "系统"
        ],
        "summary": "获取系统选项列表",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      }
    },
    "/api/wp/v1/users": {
      "get": {
        "tags": [
          "用户"
        ],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false,
        "parameters": [
          {
            "in": "query",
            "schema": {
              "type": "string",
              "enum": [
                "status",
                "last_active_time",
                "created_at"
              ]
            },
            "name": "orderBy"
          },
          {
            "in": "query",
            "schema": {
              "type": "string",
              "enum": [
                "asc",
                "desc"
              ]
            },
            "default": "desc",
            "name": "order"
          },
          {
            "in": "query",
            "schema": {
              "type": "integer"
            },
            "default": 1,
            "name": "page"
          },
          {
            "in": "query",
            "schema": {
              "type": "string"
            },
            "default": 10,
            "name": "limit"
          }
        ]
      }
    },
    "/api/wp/v1/users/me": {
      "get": {
        "tags": [
          "用户"
        ],
        "summary": "获取当前用户信息",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      },
      "patch": {
        "tags": [
          "用户"
        ],
        "summary": "修改当前用户信息",
        "description": "详细说明",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false,
        "requestBody": {
          "content": {
            "application/x-www-form-urlencoded": {
              "schema": {
                "required": [],
                "type": "object",
                "properties": {
                  "username": {
                    "type": "string"
                  },
                  "email": {
                    "type": "string"
                  },
                  "email_code": {
                    "type": "string"
                  },
                  "phone": {
                    "type": "string"
                  },
                  "phone_code": {
                    "type": "string"
                  },
                  "password": {
                    "type": "string"
                  },
                  "password_confirmation": {
                    "type": "string"
                  },
                  "salt": {
                    "type": "string"
                  }
                }
              }
            }
          },
          "required": false
        }
      }
    },
    "/api/wp/v1/users/token": {
      "post": {
        "tags": [
          "用户"
        ],
        "summary": "创建用户认证 Token",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false,
        "requestBody": {
          "content": {
            "application/x-www-form-urlencoded": {
              "schema": {
                "required": [
                  "identity",
                  "password"
                ],
                "type": "object",
                "properties": {
                  "identity": {
                    "type": "string"
                  },
                  "password": {
                    "type": "string"
                  },
                  "ttl": {
                    "type": "integer"
                  }
                }
              }
            }
          },
          "required": false
        }
      },
      "get": {
        "tags": [
          "用户"
        ],
        "summary": "验证用户 Token 有效",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false
      }
    },
    "/api/wp/v1/users/{user_ID}": {
      "get": {
        "tags": [],
        "summary": "",
        "description": "",
        "operationId": null,
        "responses": {
          "default": {
            "description": ""
          }
        },
        "deprecated": false,
        "parameters": [
          {
            "name": "user_ID",
            "in": "path",
            "required": true,
            "description": "用户ID",
            "schema": {
              "type": "string",
              "pattern": "^\\w+$"
            }
          }
        ]
      }
    }
  }
}

```
