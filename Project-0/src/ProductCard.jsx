export default function ProductCard({ product, onBuy }) {
    return (
        <div className="product-card">
            <img src={product.image} alt={product.name} width="200"/>

            <h2>{product.name}</h2>

            <p>${product.price}</p>

            <button className="buyNow" onClick={() => onBuy(product)}>
                Buy Now
            </button>
        </div>
    );
}