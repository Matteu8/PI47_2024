-- Tabela de Pedidos
CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    data_pedido DATE,
    status VARCHAR(50),
    -- Supondo que você tenha uma tabela de clientes
    CONSTRAINT fk_cliente FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

-- Tabela de Produtos (Genérica para lanches, bebidas e sobremesas)
CREATE TABLE produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(100),
    tipo_produto ENUM('lanche', 'bebida', 'sobremesa')
);

-- Tabela de Itens de Pedido
CREATE TABLE itens_pedido (
    id_item_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    id_produto INT,
    quantidade INT,
    -- Relacionando o item ao pedido
    CONSTRAINT fk_pedido FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    -- Relacionando o item ao produto
    CONSTRAINT fk_produto FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);
