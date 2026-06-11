import { useState } from "react";
import ProductCard from "./ProductCard.jsx";
import Checkout from "./Checkout.jsx";
import Confirmation from "./Confirmation.jsx";
import monitorImg from "./assets/monitor.jpg";
import laptopImg from "./assets/laptop.jpg";
import plushieImg from "./assets/plushie.jpg";

export default function ShoppingApp () {
    const [selectedProduct, setSelectedProduct] = useState(null);
    const [purchaseComplete, setPurchaseComplete] = useState(false);

    const products = [
        {
            id: 1,
            name: "Plushie",
            price: 34.99,
            image: plushieImg
        },
        {
            id: 2,
            name: "Laptop",
            price: 870.99,
            image: laptopImg
        },
        {
            id: 3,
            name: "Monitor",
            price: 169.99,
            image: monitorImg
        },
    ];

    if (purchaseComplete) {
        return (
        <Confirmation
        product={selectedProduct}
        />
    );
    }

    if (selectedProduct) {
        return (
        <Checkout
        product={selectedProduct}
        onComplete={() => setPurchaseComplete(true)}
        onBack={() => setSelectedProduct(null)}
        />
    );
  }

  return (
    <>
      <h1>Shopping App</h1>

      {products.map((product) => (
        <ProductCard
          key={product.id}
          product={product}
          onBuy={setSelectedProduct}
        />
      ))}
    </>
  );
}