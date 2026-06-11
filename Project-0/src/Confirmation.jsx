export default function Confirmation({ product}) {
    return (
    <>
    <h1>Purchase Successful!</h1>

    <p>
        Thank you for purchasing
        {" "}
        {product.name}
        {" "}
        for ${product.price}
    </p>
    </>
    );
}