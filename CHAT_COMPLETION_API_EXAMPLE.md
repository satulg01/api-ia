# Chat Completion API

Este endpoint implementa um formato moderno de chat completion similar ao OpenAI, mas que internamente utiliza o serviço HuggingFace.

## Endpoint

```
POST /api/chat/completions
```

## Formato da Requisição

```json
{
    "messages": [
        {
            "role": "user",
            "content": [
                {
                    "type": "text",
                    "text": "Explique o que é inteligência artificial em uma frase."
                }
            ]
        }
    ],
    "model": "microsoft/DialoGPT-medium",
    "stream": false,
    "temperature": 0.7,
    "max_tokens": 100
}
```

## Parâmetros

### Obrigatórios
- `messages` (array): Array de mensagens no formato de chat
  - `role` (string): Papel da mensagem - "user", "assistant" ou "system"
  - `content` (array|string): Conteúdo da mensagem
    - Para formato array: cada item deve ter `type` ("text" ou "image_url") e `text`
    - Para formato string: texto simples
- `model` (string): Nome do modelo a ser utilizado

### Opcionais
- `stream` (boolean): Se deve fazer streaming da resposta (padrão: false)
- `temperature` (float): Controla a aleatoriedade (0.0 a 2.0)
- `max_tokens` (integer): Máximo de tokens na resposta (1 a 4096)
- `top_p` (float): Nucleus sampling (0.0 a 1.0)
- `top_k` (integer): Top-k sampling (1 a 100)
- `repetition_penalty` (float): Penalidade por repetição (0.1 a 2.0)
- `max_time` (integer): Tempo máximo em segundos (1 a 120)

## Exemplos de Uso

### Exemplo 1: Texto simples
```json
{
    "messages": [
        {
            "role": "user",
            "content": "Qual é a capital do Brasil?"
        }
    ],
    "model": "microsoft/DialoGPT-medium",
    "temperature": 0.7
}
```

### Exemplo 2: Formato estruturado
```json
{
    "messages": [
        {
            "role": "user",
            "content": [
                {
                    "type": "text",
                    "text": "Explique como funciona a inteligência artificial"
                }
            ]
        }
    ],
    "model": "microsoft/DialoGPT-large",
    "stream": false,
    "temperature": 0.5,
    "max_tokens": 500
}
```

### Exemplo 3: Conversa com contexto
```json
{
    "messages": [
        {
            "role": "system",
            "content": "Você é um assistente especializado em tecnologia."
        },
        {
            "role": "user",
            "content": "O que é machine learning?"
        },
        {
            "role": "assistant",
            "content": "Machine learning é uma área da inteligência artificial..."
        },
        {
            "role": "user",
            "content": "Quais são os principais tipos?"
        }
    ],
    "model": "microsoft/DialoGPT-medium",
    "temperature": 0.7,
    "max_tokens": 300
}
```

## Resposta

A resposta segue o mesmo formato dos outros endpoints:

```json
{
    "success": true,
    "data": {
        "response": "Resposta do modelo aqui...",
        "model": "microsoft/DialoGPT-medium",
        "usage": {
            "prompt_tokens": 25,
            "completion_tokens": 50,
            "total_tokens": 75
        }
    }
}
```

## Códigos de Erro

- `400 Bad Request`: Dados de entrada inválidos
- `500 Internal Server Error`: Erro interno do servidor ou na API do HuggingFace

## Modelos Suportados

Este endpoint suporta modelos disponíveis na API Inference do HuggingFace, incluindo:
- `microsoft/DialoGPT-medium` (recomendado para chat)
- `microsoft/DialoGPT-large` (versão mais avançada)
- `facebook/blenderbot-400M-distill` (bot conversacional)
- `google/flan-t5-base` (modelo de instrução)
- `EleutherAI/gpt-neo-2.7B` (geração de texto)
- `bigscience/bloom-560m` (modelo multilíngue)

**Nota**: Nem todos os modelos do HuggingFace estão disponíveis na API Inference gratuita. Use modelos testados e documentados.

## Diferenças do Formato Original

O endpoint `/api/chat/completions` oferece um formato mais moderno e flexível comparado ao `/api/huggingface-chat`:

1. **Estrutura de mensagens**: Suporte a conversas com múltiplas mensagens e roles
2. **Conteúdo estruturado**: Suporte a diferentes tipos de conteúdo (texto, imagem)
3. **Compatibilidade**: Formato similar ao OpenAI ChatCompletion
4. **Flexibilidade**: Melhor organização para aplicações de chat

## Configuração Necessária

Antes de usar o endpoint, certifique-se de que a chave da API do HuggingFace está configurada:

1. Adicione no seu arquivo `.env`:
```
HUGGINGFACE_API_KEY=hf_your-huggingface-token-here
```

2. Obtenha sua chave em: https://huggingface.co/settings/tokens

## Nota Importante

Embora o formato seja moderno, internamente o endpoint ainda utiliza o serviço HuggingFace existente. A primeira mensagem do usuário é extraída e enviada para o modelo selecionado.

**Troubleshooting:**
- Se receber erro 404, verifique se o modelo existe na API Inference do HuggingFace
- Se receber erro 401, verifique sua chave da API
- Alguns modelos podem estar "dormindo" e precisam ser carregados na primeira requisição 