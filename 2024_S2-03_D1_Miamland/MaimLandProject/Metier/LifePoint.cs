using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.NetworkInformation;
using System.Text;
using System.Threading.Tasks;
using IUTGame;

namespace MaimLandProject.Metier
{
    public class LifePoint : IUTGame.GameItem
    {
        #region attribut
        private int vie;
        #endregion

        #region constructeur
        /// <summary>
        /// initial point de vie, image va changer quand pv changer
        /// </summary>
        /// <param name="pv"> point de vie</param>
        /// <param name="x"> coordonnee X </param>
        /// <param name="y"> coordonnee Y </param>
        /// <param name="game"> jeu </param>
        public LifePoint(int pv, double x, double y, Game game) : base(x, y, game, $"life{pv}.png")
        {
            vie = pv;
        }
        #endregion

        #region propriétés
        public override string TypeName => "Point de Vie";

        public int Vie
        {
            get { return vie; }
            set 
            {
                vie = value;
                ChangeSprite(string.Format("life{0}.png",vie));
            }
        }
        #endregion

        #region methode
        /// <summary>
        /// perdu le point de vie
        /// </summary>
        public void PerdreVie()
        {
            Vie--;
        }

        public override void CollideEffect(GameItem other)
        {
            
        }
        #endregion
    }
}
