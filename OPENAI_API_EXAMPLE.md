# OpenAI API Integration Example

Este documento demonstra como usar o endpoint da OpenAI integrado à aplicação Laravel.

## Configuração

1. Adicione sua chave da API da OpenAI no arquivo `.env`:
```
OPENAI_API_KEY=sk-your-openai-api-key-here
```

## Endpoint

**POST** `/api/openai-chat`

### Headers
```
Content-Type: application/json
Accept: application/json
```

### Parâmetros da Requisição

| Campo | Tipo | Obrigatório | Descrição | Valores Aceitos |
|-------|------|-------------|-----------|-----------------|
| `question` | string | Sim | A pergunta/prompt para a OpenAI | Máximo 4000 caracteres |
| `temperature` | float | Não | Controla a criatividade da resposta | 0.0 a 2.0 (padrão: 0.7) |
| `model` | string | Não | Modelo da OpenAI a ser usado | gpt-3.5-turbo, gpt-4, gpt-4-turbo, gpt-4o, gpt-4o-mini (padrão: gpt-3.5-turbo) |
| `max_tokens` | integer | Não | Número máximo de tokens na resposta | 1 a 4096 |
| `top_p` | float | Não | Controla a diversidade da resposta | 0.0 a 1.0 |
| `frequency_penalty` | float | Não | Penaliza repetições de palavras | -2.0 a 2.0 |
| `presence_penalty` | float | Não | Penaliza tópicos já mencionados | -2.0 a 2.0 |

### Exemplo de Requisição

```bash
curl -X POST http://localhost:8000/api/openai-chat \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "question": "Explique o que é inteligência artificial de forma simples",
    "temperature": 0.7,
    "model": "gpt-3.5-turbo",
    "max_tokens": 500
  }'
```

### Exemplo de Resposta (Sucesso)

```json
{
  "success": true,
  "data": {
    "content": "Inteligência Artificial (IA) é uma tecnologia que permite que computadores e máquinas realizem tarefas que normalmente exigiriam inteligência humana...",
    "model": "gpt-3.5-turbo-0125",
    "finish_reason": "stop",
    "usage": {
      "prompt_tokens": 25,
      "completion_tokens": 150,
      "total_tokens": 175
    }
  }
}
```

### Exemplo de Resposta (Erro)

```json
{
  "success": false,
  "message": "Failed to process OpenAI chat request",
  "error": "OpenAI API request failed: 401 - Invalid API key"
}
```

## Modelos Disponíveis

- **gpt-3.5-turbo**: Modelo mais rápido e econômico
- **gpt-4**: Modelo mais capaz, melhor para tarefas complexas
- **gpt-4-turbo**: Versão otimizada do GPT-4
- **gpt-4o**: Modelo multimodal mais recente
- **gpt-4o-mini**: Versão mais leve do GPT-4o

## Exemplo com JavaScript

```javascript
const response = await fetch('/api/openai-chat', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    question: 'Como funciona o machine learning?',
    temperature: 0.8,
    model: 'gpt-4',
    max_tokens: 1000
  })
});

const data = await response.json();
console.log(data.data.content);
```