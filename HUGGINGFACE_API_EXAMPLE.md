# Hugging Face API Integration Example

Este documento demonstra como usar o endpoint do Hugging Face integrado à aplicação Laravel.

## Configuração

1. Adicione sua chave da API do Hugging Face no arquivo `.env`:
```
HUGGINGFACE_API_KEY=hf_your-huggingface-token-here
```

2. Obtenha sua chave da API em: https://huggingface.co/settings/tokens

## Endpoint

**POST** `/api/huggingface-chat`

### Headers
```
Content-Type: application/json
Accept: application/json
```

### Parâmetros da Requisição

| Campo | Tipo | Obrigatório | Descrição | Valores Aceitos |
|-------|------|-------------|-----------|-----------------|
| `question` | string | Sim | A pergunta/prompt para o modelo | Máximo 4000 caracteres |
| `model` | string | Não | Nome do modelo do Hugging Face | Qualquer modelo disponível (padrão: microsoft/DialoGPT-medium) |
| `max_length` | integer | Não | Comprimento máximo da resposta | 10 a 1000 (padrão: 100) |
| `temperature` | float | Não | Controla a criatividade da resposta | 0.0 a 2.0 (padrão: 0.7) |
| `do_sample` | boolean | Não | Se deve usar amostragem | true/false (padrão: true) |
| `top_p` | float | Não | Controla a diversidade da resposta | 0.0 a 1.0 |
| `top_k` | integer | Não | Número de tokens mais prováveis | 1 a 100 |
| `repetition_penalty` | float | Não | Penaliza repetições | 0.1 a 2.0 |
| `max_time` | integer | Não | Tempo máximo de processamento (segundos) | 1 a 120 |

### Modelos Populares

- **microsoft/DialoGPT-medium**: Conversação geral
- **microsoft/DialoGPT-large**: Conversação mais avançada
- **facebook/blenderbot-400M-distill**: Bot conversacional
- **google/flan-t5-base**: Modelo de instrução
- **EleutherAI/gpt-neo-2.7B**: Geração de texto
- **bigscience/bloom-560m**: Modelo multilíngue

### Exemplo de Requisição

```bash
curl -X POST http://localhost:8000/api/huggingface-chat \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "question": "Explique o que é machine learning",
    "model": "microsoft/DialoGPT-medium",
    "max_length": 200,
    "temperature": 0.8,
    "do_sample": true
  }'
```

### Exemplo de Resposta (Sucesso)

```json
{
  "success": true,
  "data": {
    "content": "Machine learning é uma área da inteligência artificial que permite que computadores aprendam e melhorem automaticamente através da experiência, sem serem explicitamente programados...",
    "model": "microsoft/DialoGPT-medium",
    "warnings": null,
    "processing_time": 2.5
  }
}
```

### Exemplo de Resposta (Modelo Carregando)

```json
{
  "success": false,
  "message": "Failed to process Hugging Face chat request",
  "error": "Model is currently loading, please try again in a few moments: Model microsoft/DialoGPT-medium is currently loading"
}
```

### Exemplo de Resposta (Erro)

```json
{
  "success": false,
  "message": "Failed to process Hugging Face chat request",
  "error": "Hugging Face API request failed: 401 - Invalid API token"
}
```

## Exemplo com JavaScript

```javascript
const response = await fetch('/api/huggingface-chat', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    question: 'Como criar uma aplicação web moderna?',
    model: 'microsoft/DialoGPT-large',
    max_length: 300,
    temperature: 0.9,
    top_p: 0.95
  })
});

const data = await response.json();
if (data.success) {
  console.log(data.data.content);
} else {
  console.error(data.error);
}
```

## Validações

- `question`: Obrigatório, máximo 4000 caracteres
- `model`: Opcional, máximo 200 caracteres
- `max_length`: Opcional, entre 10 e 1000
- `temperature`: Opcional, entre 0.0 e 2.0
- `do_sample`: Opcional, boolean
- `top_p`: Opcional, entre 0.0 e 1.0
- `top_k`: Opcional, entre 1 e 100
- `repetition_penalty`: Opcional, entre 0.1 e 2.0
- `max_time`: Opcional, entre 1 e 120 segundos

## Características Especiais do Hugging Face

### 1. Modelos Gratuitos
- Muitos modelos são gratuitos para uso
- API Inference gratuita com rate limits

### 2. Carregamento de Modelos
- Modelos podem estar "dormindo" e precisam ser carregados
- Primeira requisição pode ser mais lenta
- Mensagem específica quando modelo está carregando

### 3. Diversidade de Modelos
- Modelos para diferentes tarefas: conversação, tradução, resumo
- Modelos em diferentes idiomas
- Diferentes tamanhos e capacidades

### 4. Rate Limits
- API gratuita tem limitações de uso
- Para uso intensivo, considere Hugging Face Pro

## Tratamento de Erros

O endpoint retorna diferentes tipos de erro:

- **400 Bad Request**: Dados de entrada inválidos
- **401 Unauthorized**: Token da API inválido
- **429 Too Many Requests**: Rate limit excedido
- **500 Internal Server Error**: Erro interno ou modelo indisponível
- **503 Service Unavailable**: Modelo carregando